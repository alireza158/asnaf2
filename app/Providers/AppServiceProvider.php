<?php

namespace App\Providers;

use App\Models\InternalMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('Helpers/date.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer(['admin.partials.sidebar', 'admin.partials.header'], function ($view) {
            $view->with('unreadMessagesCount', auth()->check()
                ? InternalMessage::query()->where('recipient_id', auth()->id())->whereNull('read_at')->count()
                : 0);
        });
    }
}
