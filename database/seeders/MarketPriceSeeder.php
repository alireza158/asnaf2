<?php

namespace Database\Seeders;

use App\Models\MarketPrice;
use Illuminate\Database\Seeder;

class MarketPriceSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['key' => 'gold_18k', 'title' => 'طلای ۱۸ عیار', 'category' => 'gold', 'price' => 3500000, 'currency' => 'تومان', 'unit' => 'گرم', 'sort_order' => 1],
            ['key' => 'gold_24k', 'title' => 'طلای ۲۴ عیار', 'category' => 'gold', 'price' => 4660000, 'currency' => 'تومان', 'unit' => 'گرم', 'sort_order' => 2],
            ['key' => 'silver', 'title' => 'نقره', 'category' => 'metal', 'price' => 65000, 'currency' => 'تومان', 'unit' => 'گرم', 'sort_order' => 3],
            ['key' => 'coin_emami', 'title' => 'سکه امامی', 'category' => 'coin', 'price' => 42000000, 'currency' => 'تومان', 'unit' => 'عدد', 'sort_order' => 4],
            ['key' => 'coin_bahar', 'title' => 'سکه بهار آزادی', 'category' => 'coin', 'price' => 39000000, 'currency' => 'تومان', 'unit' => 'عدد', 'sort_order' => 5],
            ['key' => 'half_coin', 'title' => 'نیم سکه', 'category' => 'coin', 'price' => 23000000, 'currency' => 'تومان', 'unit' => 'عدد', 'sort_order' => 6],
            ['key' => 'quarter_coin', 'title' => 'ربع سکه', 'category' => 'coin', 'price' => 14500000, 'currency' => 'تومان', 'unit' => 'عدد', 'sort_order' => 7],
            ['key' => 'usd', 'title' => 'دلار آمریکا', 'category' => 'currency', 'price' => 60000, 'currency' => 'تومان', 'unit' => 'اسکناس', 'sort_order' => 8],
            ['key' => 'eur', 'title' => 'یورو', 'category' => 'currency', 'price' => 65000, 'currency' => 'تومان', 'unit' => 'اسکناس', 'sort_order' => 9],
            ['key' => 'aed', 'title' => 'درهم امارات', 'category' => 'currency', 'price' => 16500, 'currency' => 'تومان', 'unit' => 'اسکناس', 'sort_order' => 10],
            ['key' => 'try', 'title' => 'لیر ترکیه', 'category' => 'currency', 'price' => 2000, 'currency' => 'تومان', 'unit' => 'اسکناس', 'sort_order' => 11],
        ];

        foreach ($items as $item) {
            MarketPrice::query()->updateOrCreate(
                ['key' => $item['key']],
                $item + ['is_active' => true]
            );
        }
    }
}
