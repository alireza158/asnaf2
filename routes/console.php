<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Server cron required for Laravel scheduler:
// * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
Schedule::command('market-prices:fetch')->hourly()->withoutOverlapping();
