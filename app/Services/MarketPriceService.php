<?php

namespace App\Services;

use App\Models\MarketPrice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MarketPriceService
{
    /**
     * @var array<string, array{title: string, category: string, unit: string, sort_order: int, aliases: array<int, string>}>
     */
    private array $definitions = [
        'gold_18k' => ['title' => 'طلای ۱۸ عیار', 'category' => 'gold', 'unit' => 'گرم', 'sort_order' => 1, 'aliases' => ['gold_18k', 'gold18', 'gold_18', 'geram18', 'geram18ayar']],
        'gold_24k' => ['title' => 'طلای ۲۴ عیار', 'category' => 'gold', 'unit' => 'گرم', 'sort_order' => 2, 'aliases' => ['gold_24k', 'gold24', 'gold_24']],
        'silver' => ['title' => 'نقره', 'category' => 'metal', 'unit' => 'گرم', 'sort_order' => 3, 'aliases' => ['silver', 'silver_gram']],
        'coin_emami' => ['title' => 'سکه امامی', 'category' => 'coin', 'unit' => 'عدد', 'sort_order' => 4, 'aliases' => ['coin_emami', 'emami', 'sekke_emami']],
        'coin_bahar' => ['title' => 'سکه بهار آزادی', 'category' => 'coin', 'unit' => 'عدد', 'sort_order' => 5, 'aliases' => ['coin_bahar', 'bahar', 'sekke_bahar']],
        'half_coin' => ['title' => 'نیم سکه', 'category' => 'coin', 'unit' => 'عدد', 'sort_order' => 6, 'aliases' => ['half_coin', 'nim', 'nim_sekke']],
        'quarter_coin' => ['title' => 'ربع سکه', 'category' => 'coin', 'unit' => 'عدد', 'sort_order' => 7, 'aliases' => ['quarter_coin', 'rob', 'rob_sekke']],
        'usd' => ['title' => 'دلار آمریکا', 'category' => 'currency', 'unit' => 'اسکناس', 'sort_order' => 8, 'aliases' => ['usd', 'dollar', 'us_dollar']],
        'eur' => ['title' => 'یورو', 'category' => 'currency', 'unit' => 'اسکناس', 'sort_order' => 9, 'aliases' => ['eur', 'euro']],
        'aed' => ['title' => 'درهم امارات', 'category' => 'currency', 'unit' => 'اسکناس', 'sort_order' => 10, 'aliases' => ['aed', 'dirham']],
        'try' => ['title' => 'لیر ترکیه', 'category' => 'currency', 'unit' => 'اسکناس', 'sort_order' => 11, 'aliases' => ['try', 'turkish_lira', 'lira']],
    ];

    public function fetchAndUpdate(): void
    {
        $sourceUrl = trim((string) config('services.market_prices.source_url'));
        $sourceName = trim((string) config('services.market_prices.source_name', '')) ?: null;

        if ($sourceUrl === '') {
            Log::info('Market price source URL is not configured; keeping existing database values.');

            return;
        }

        try {
            $response = Http::timeout(15)->get($sourceUrl);
            $response->throw();

            $payload = $response->json();
            if (! is_array($payload)) {
                Log::warning('Market price source returned a non-JSON or invalid payload.', ['source_url' => $sourceUrl]);

                return;
            }

            foreach ($this->itemsFromPayload($payload) as $item) {
                $item['source_name'] = $item['source_name'] ?? $sourceName;
                $item['source_url'] = $item['source_url'] ?? $sourceUrl;
                $item['fetched_at'] = $item['fetched_at'] ?? now();
                $this->upsertPrice($item);
            }
        } catch (Throwable $e) {
            Log::error('Market price fetch failed; keeping previous database values.', [
                'source_url' => $sourceUrl,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function getActivePrices(): Collection
    {
        try {
            return MarketPrice::query()
                ->active()
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();
        } catch (Throwable $e) {
            Log::error('Active market prices could not be loaded.', ['message' => $e->getMessage()]);

            return new Collection();
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function itemsFromPayload(array $payload): array
    {
        $rows = Arr::get($payload, 'data.prices')
            ?? Arr::get($payload, 'prices')
            ?? Arr::get($payload, 'data')
            ?? $payload;

        if (! is_array($rows)) {
            return [];
        }

        $items = [];
        foreach ($this->definitions as $key => $definition) {
            $raw = $this->findRawItem($rows, $key, $definition['aliases']);

            if ($raw === null) {
                continue;
            }

            $price = is_array($raw)
                ? $this->normalizePrice($raw['price'] ?? $raw['value'] ?? $raw['amount'] ?? $raw['last'] ?? null)
                : $this->normalizePrice($raw);

            if ($price === null) {
                continue;
            }

            $items[] = array_merge($definition, [
                'key' => $key,
                'price' => $price,
                'change_amount' => is_array($raw) ? $this->normalizePrice($raw['change_amount'] ?? $raw['change'] ?? null) : null,
                'change_percent' => is_array($raw) ? $this->normalizePrice($raw['change_percent'] ?? $raw['percent'] ?? null) : null,
                'currency' => is_array($raw) ? ($raw['currency'] ?? 'تومان') : 'تومان',
                'unit' => is_array($raw) ? ($raw['unit'] ?? $definition['unit']) : $definition['unit'],
                'raw_data' => is_array($raw) ? $raw : ['value' => $raw],
            ]);
        }

        return $items;
    }

    /**
     * @param array<int|string, mixed> $rows
     * @param array<int, string> $aliases
     */
    private function findRawItem(array $rows, string $key, array $aliases): mixed
    {
        foreach (array_unique(array_merge([$key], $aliases)) as $alias) {
            if (array_key_exists($alias, $rows)) {
                return $rows[$alias];
            }
        }

        foreach ($rows as $row) {
            if (! is_array($row)) {
                continue;
            }

            $rowKey = (string) ($row['key'] ?? $row['symbol'] ?? $row['code'] ?? '');
            if (in_array($rowKey, array_merge([$key], $aliases), true)) {
                return $row;
            }
        }

        return null;
    }

    private function normalizePrice(mixed $value): ?float
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_numeric($value)) {
            return (float) $value;
        }

        $normalized = strtr((string) $value, [
            '۰' => '0', '۱' => '1', '۲' => '2', '۳' => '3', '۴' => '4',
            '۵' => '5', '۶' => '6', '۷' => '7', '۸' => '8', '۹' => '9',
            '٠' => '0', '١' => '1', '٢' => '2', '٣' => '3', '٤' => '4',
            '٥' => '5', '٦' => '6', '٧' => '7', '٨' => '8', '٩' => '9',
            ',' => '', '٬' => '', ' ' => '', '%' => '', '٪' => '',
        ]);

        return is_numeric($normalized) ? (float) $normalized : null;
    }

    private function upsertPrice(array $item): void
    {
        $marketPrice = MarketPrice::query()->firstOrNew(['key' => $item['key']]);

        $marketPrice->fill(Arr::only($item, [
            'title',
            'category',
            'price',
            'change_amount',
            'change_percent',
            'currency',
            'unit',
            'source_name',
            'source_url',
            'fetched_at',
            'sort_order',
            'raw_data',
        ]));

        if (! $marketPrice->exists) {
            $marketPrice->is_active = true;
        }

        $marketPrice->save();
    }
}
