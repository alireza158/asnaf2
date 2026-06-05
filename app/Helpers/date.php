<?php

use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;

if (! function_exists('jalali_date')) {
    function jalali_date($date, string $format = 'Y/m/d'): string
    {
        return jalali_datetime($date, $format);
    }
}

if (! function_exists('jalali_datetime')) {
    function jalali_datetime($date, string $format = 'Y/m/d H:i'): string
    {
        if ($date === null || $date === '') {
            return '—';
        }

        try {
            $carbon = $date instanceof CarbonInterface ? $date : Carbon::parse($date);

            if (class_exists(Jalalian::class)) {
                return Jalalian::fromCarbon($carbon)->format($format);
            }

            return fallback_jalali_format($carbon, $format);
        } catch (Throwable) {
            return '—';
        }
    }
}

if (! function_exists('jalali_to_gregorian_datetime')) {
    function jalali_to_gregorian_datetime(?string $date, ?string $time = null): ?string
    {
        if ($date === null || trim($date) === '') {
            return null;
        }

        $value = str_replace('-', '/', trim($date));
        $value = preg_replace('/\s+/', ' ', $value);

        if ($time !== null && trim($time) !== '') {
            $value = trim($value).' '.trim($time);
        }

        try {
            if (class_exists(Jalalian::class)) {
                $format = str_contains($value, ' ') ? 'Y/m/d H:i' : 'Y/m/d';
                $carbon = Jalalian::fromFormat($format, $value)->toCarbon();

                return $format === 'Y/m/d'
                    ? $carbon->startOfDay()->format('Y-m-d H:i:s')
                    : $carbon->format('Y-m-d H:i:s');
            }

            if (! preg_match('/^(\d{4})\/(\d{1,2})\/(\d{1,2})(?:\s+(\d{1,2}):(\d{1,2}))?$/', $value, $matches)) {
                return null;
            }

            [$gy, $gm, $gd] = fallback_jalali_to_gregorian((int) $matches[1], (int) $matches[2], (int) $matches[3]);
            $hour = isset($matches[4]) ? (int) $matches[4] : 0;
            $minute = isset($matches[5]) ? (int) $matches[5] : 0;

            return Carbon::create($gy, $gm, $gd, $hour, $minute)->format('Y-m-d H:i:s');
        } catch (Throwable) {
            return null;
        }
    }
}


if (! function_exists('normalize_jalali_request_dates')) {
    function normalize_jalali_request_dates($request, array $fields): void
    {
        $dates = [];

        foreach ($fields as $field) {
            if (! $request->has($field)) {
                continue;
            }

            $value = $request->input($field);

            if ($value === null || trim((string) $value) === '') {
                $dates[$field] = null;
                continue;
            }

            $converted = jalali_to_gregorian_datetime((string) $value);

            if ($converted !== null) {
                $dates[$field] = $converted;
            }
        }

        if ($dates !== []) {
            $request->merge($dates);
        }
    }
}

if (! function_exists('jalali_form_datetime')) {
    function jalali_form_datetime($date, string $format = 'Y/m/d H:i'): string
    {
        $formatted = jalali_datetime($date, $format);

        return $formatted === '—' ? '' : $formatted;
    }
}

if (! function_exists('fallback_jalali_format')) {
    function fallback_jalali_format(CarbonInterface $carbon, string $format): string
    {
        [$year, $month, $day] = fallback_gregorian_to_jalali((int) $carbon->format('Y'), (int) $carbon->format('m'), (int) $carbon->format('d'));

        $replacements = [
            'Y' => sprintf('%04d', $year),
            'y' => substr((string) $year, -2),
            'm' => sprintf('%02d', $month),
            'n' => (string) $month,
            'd' => sprintf('%02d', $day),
            'j' => (string) $day,
            'H' => $carbon->format('H'),
            'i' => $carbon->format('i'),
            's' => $carbon->format('s'),
        ];

        return strtr($format, $replacements);
    }
}

if (! function_exists('fallback_gregorian_to_jalali')) {
    function fallback_gregorian_to_jalali(int $gy, int $gm, int $gd): array
    {
        $gDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $jDaysInMonth = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

        $gy -= 1600;
        $gm -= 1;
        $gd -= 1;

        $gDayNo = 365 * $gy + intdiv($gy + 3, 4) - intdiv($gy + 99, 100) + intdiv($gy + 399, 400);

        for ($i = 0; $i < $gm; $i++) {
            $gDayNo += $gDaysInMonth[$i];
        }

        if ($gm > 1 && (($gy % 4 === 0 && $gy % 100 !== 0) || ($gy % 400 === 0))) {
            $gDayNo++;
        }

        $gDayNo += $gd;
        $jDayNo = $gDayNo - 79;
        $jNp = intdiv($jDayNo, 12053);
        $jDayNo %= 12053;
        $jy = 979 + 33 * $jNp + 4 * intdiv($jDayNo, 1461);
        $jDayNo %= 1461;

        if ($jDayNo >= 366) {
            $jy += intdiv($jDayNo - 1, 365);
            $jDayNo = ($jDayNo - 1) % 365;
        }

        for ($i = 0; $i < 11 && $jDayNo >= $jDaysInMonth[$i]; $i++) {
            $jDayNo -= $jDaysInMonth[$i];
        }

        return [$jy, $i + 1, $jDayNo + 1];
    }
}

if (! function_exists('fallback_jalali_to_gregorian')) {
    function fallback_jalali_to_gregorian(int $jy, int $jm, int $jd): array
    {
        $gDaysInMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        $jDaysInMonth = [31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29];

        $jy -= 979;
        $jm -= 1;
        $jd -= 1;

        $jDayNo = 365 * $jy + intdiv($jy, 33) * 8 + intdiv(($jy % 33) + 3, 4);

        for ($i = 0; $i < $jm; $i++) {
            $jDayNo += $jDaysInMonth[$i];
        }

        $jDayNo += $jd;
        $gDayNo = $jDayNo + 79;
        $gy = 1600 + 400 * intdiv($gDayNo, 146097);
        $gDayNo %= 146097;

        $leap = true;
        if ($gDayNo >= 36525) {
            $gDayNo--;
            $gy += 100 * intdiv($gDayNo, 36524);
            $gDayNo %= 36524;

            if ($gDayNo >= 365) {
                $gDayNo++;
            } else {
                $leap = false;
            }
        }

        $gy += 4 * intdiv($gDayNo, 1461);
        $gDayNo %= 1461;

        if ($gDayNo >= 366) {
            $leap = false;
            $gDayNo--;
            $gy += intdiv($gDayNo, 365);
            $gDayNo %= 365;
        }

        for ($i = 0; $gDayNo >= $gDaysInMonth[$i] + ($i === 1 && $leap ? 1 : 0); $i++) {
            $gDayNo -= $gDaysInMonth[$i] + ($i === 1 && $leap ? 1 : 0);
        }

        return [$gy, $i + 1, $gDayNo + 1];
    }
}
