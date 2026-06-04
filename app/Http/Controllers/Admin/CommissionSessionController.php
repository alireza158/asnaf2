<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\CommissionSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CommissionSessionController extends Controller
{
    public function index(Commission $commission): View
    {
        $sessions = $commission->sessions()->paginate(15);

        return view('admin.commission_sessions.index', compact('commission', 'sessions'));
    }

    public function create(Commission $commission): View
    {
        return view('admin.commission_sessions.create', ['commission' => $commission, 'statusLabels' => CommissionSession::statusLabels()]);
    }

    public function store(Request $request, Commission $commission): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $session = $commission->sessions()->create([
            ...$this->sessionData($validated),
            'minutes_file' => $request->hasFile('minutes_file') ? $request->file('minutes_file')->store('commission-sessions/minutes', 'public') : null,
            'attachments' => $this->storeFiles($request, 'attachments', 'commission-sessions/attachments'),
            'images' => $this->storeFiles($request, 'images', 'commission-sessions/images'),
        ]);

        return redirect()->route('admin.commissions.sessions.show', [$commission, $session])->with('success', 'جلسه کمیسیون با موفقیت ایجاد شد.');
    }

    public function show(Commission $commission, CommissionSession $session): View
    {
        $this->ensureSessionBelongsToCommission($commission, $session);

        return view('admin.commission_sessions.show', compact('commission', 'session'));
    }

    public function edit(Commission $commission, CommissionSession $session): View
    {
        $this->ensureSessionBelongsToCommission($commission, $session);

        return view('admin.commission_sessions.edit', [
            'commission' => $commission,
            'session' => $session,
            'statusLabels' => CommissionSession::statusLabels(),
            'sessionDateJalali' => $session->session_date ? $this->gregorianToJalali($session->session_date->format('Y-m-d')) : '',
        ]);
    }

    public function update(Request $request, Commission $commission, CommissionSession $session): RedirectResponse
    {
        $this->ensureSessionBelongsToCommission($commission, $session);
        $validated = $this->validatedData($request, $session);
        $data = $this->sessionData($validated);

        if ($request->hasFile('minutes_file')) {
            if ($session->minutes_file) {
                Storage::disk('public')->delete($session->minutes_file);
            }
            $data['minutes_file'] = $request->file('minutes_file')->store('commission-sessions/minutes', 'public');
        }

        $data['attachments'] = $this->syncFiles($request, $session, 'attachments', 'commission-sessions/attachments');
        $data['images'] = $this->syncFiles($request, $session, 'images', 'commission-sessions/images');
        $session->update($data);

        return redirect()->route('admin.commissions.sessions.show', [$commission, $session])->with('success', 'جلسه کمیسیون با موفقیت ویرایش شد.');
    }

    public function destroy(Commission $commission, CommissionSession $session): RedirectResponse
    {
        $this->ensureSessionBelongsToCommission($commission, $session);
        if ($session->minutes_file) {
            Storage::disk('public')->delete($session->minutes_file);
        }
        foreach (array_merge($session->attachments ?? [], $session->images ?? []) as $file) {
            Storage::disk('public')->delete($file['path'] ?? '');
        }
        $session->delete();

        return redirect()->route('admin.commissions.sessions.index', $commission)->with('success', 'جلسه کمیسیون با موفقیت حذف شد.');
    }

    private function validatedData(Request $request, ?CommissionSession $session = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'session_date_jalali' => ['nullable', 'regex:/^\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2}$/'],
            'session_time' => ['nullable', 'date_format:H:i'],
            'minutes_file' => ['nullable', 'file', 'max:10240'],
            'attachments' => ['nullable', 'array'],
            'attachments.*' => ['file', 'max:10240'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
            'existing_attachments' => ['nullable', 'array'],
            'existing_images' => ['nullable', 'array'],
            'status' => ['required', Rule::in(CommissionSession::STATUSES)],
            'published_at' => ['nullable', 'date'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', Rule::in(['0', '1'])],
        ]);
    }

    private function sessionData(array $validated): array
    {
        return [
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'session_date' => $this->jalaliDateTimeToGregorian($validated['session_date_jalali'] ?? null, $validated['session_time'] ?? null),
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) $validated['is_active'],
        ];
    }

    private function storeFiles(Request $request, string $field, string $directory): array
    {
        if (! $request->hasFile($field)) {
            return [];
        }
        return collect($request->file($field))->map(fn ($file) => ['name' => $file->getClientOriginalName(), 'path' => $file->store($directory, 'public')])->values()->all();
    }

    private function syncFiles(Request $request, CommissionSession $session, string $field, string $directory): array
    {
        $existingField = 'existing_'.$field;
        $existing = collect($session->{$field} ?? [])->map(function ($file, $index) use ($request, $existingField) {
            $payload = $request->input("{$existingField}.{$index}", []);
            $file['delete'] = ($payload['delete'] ?? null) === '1';
            return $file;
        });
        $existing->where('delete', true)->each(fn ($file) => Storage::disk('public')->delete($file['path'] ?? ''));

        return $existing->reject(fn ($file) => $file['delete'])->map(fn ($file) => collect($file)->except('delete')->all())->values()
            ->merge($this->storeFiles($request, $field, $directory))->all();
    }

    private function ensureSessionBelongsToCommission(Commission $commission, CommissionSession $session): void
    {
        abort_if($session->commission_id !== $commission->id, 404);
    }

    private function jalaliDateTimeToGregorian(?string $date, ?string $time): ?string
    {
        if (! $date) {
            return null;
        }
        [$jy, $jm, $jd] = array_map('intval', preg_split('/[\/\-]/', $date));
        [$gy, $gm, $gd] = $this->jalaliToGregorian($jy, $jm, $jd);
        return sprintf('%04d-%02d-%02d %s:00', $gy, $gm, $gd, $time ?: '00:00');
    }

    private function jalaliToGregorian(int $jy, int $jm, int $jd): array
    {
        $jy += 1595;
        $days = -355668 + (365 * $jy) + intdiv($jy, 33) * 8 + intdiv(($jy % 33) + 3, 4) + $jd + (($jm < 7) ? (($jm - 1) * 31) : ((($jm - 7) * 30) + 186));
        $gy = 400 * intdiv($days, 146097); $days %= 146097;
        if ($days > 36524) { $gy += 100 * intdiv(--$days, 36524); $days %= 36524; if ($days >= 365) { $days++; } }
        $gy += 4 * intdiv($days, 1461); $days %= 1461;
        if ($days > 365) { $gy += intdiv($days - 1, 365); $days = ($days - 1) % 365; }
        $gd = $days + 1;
        $sal = [0, 31, (($gy % 4 === 0 && $gy % 100 !== 0) || ($gy % 400 === 0)) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        for ($gm = 1; $gm <= 12 && $gd > $sal[$gm]; $gm++) { $gd -= $sal[$gm]; }
        return [$gy, $gm, $gd];
    }

    private function gregorianToJalali(string $date): string
    {
        [$gy, $gm, $gd] = array_map('intval', explode('-', $date));
        $gdm = [0,31,59,90,120,151,181,212,243,273,304,334];
        $gy2 = ($gm > 2) ? ($gy + 1) : $gy;
        $days = 355666 + (365 * $gy) + intdiv($gy2 + 3, 4) - intdiv($gy2 + 99, 100) + intdiv($gy2 + 399, 400) + $gd + $gdm[$gm - 1];
        $jy = -1595 + (33 * intdiv($days, 12053)); $days %= 12053;
        $jy += 4 * intdiv($days, 1461); $days %= 1461;
        if ($days > 365) { $jy += intdiv($days - 1, 365); $days = ($days - 1) % 365; }
        if ($days < 186) { $jm = 1 + intdiv($days, 31); $jd = 1 + ($days % 31); }
        else { $jm = 7 + intdiv($days - 186, 30); $jd = 1 + (($days - 186) % 30); }
        return sprintf('%04d/%02d/%02d', $jy, $jm, $jd);
    }
}
