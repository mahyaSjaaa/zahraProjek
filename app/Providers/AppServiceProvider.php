<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Pakai Bootstrap 5 untuk pagination
        Paginator::useBootstrapFive();
        // kalau project-mu masih Bootstrap 4, gunakan:
        // Paginator::useBootstrapFour();
        if ($this->app->environment('production')) {
            \URL::forceScheme('https');
    }
    }
}
