<?php

namespace App\Providers;

use App\Http\Middleware\CustomRequirePassword;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RequirePassword::class, CustomRequirePassword::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
