<?php

namespace App\Console\Commands;

use App\Services\MarketPriceService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class FetchMarketPrices extends Command
{
    protected $signature = 'market-prices:fetch';

    protected $description = 'Fetch and update daily gold, coin, silver and currency prices.';

    public function handle(MarketPriceService $marketPriceService): int
    {
        try {
            $marketPriceService->fetchAndUpdate();
            $this->info('Market prices updated successfully.');

            return self::SUCCESS;
        } catch (Throwable $e) {
            $this->error($e->getMessage());
            Log::error('Market price fetch failed', [
                'message' => $e->getMessage(),
                'exception' => $e,
            ]);

            return self::FAILURE;
        }
    }
}
