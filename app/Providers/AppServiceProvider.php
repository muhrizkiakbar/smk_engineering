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
        $this->app->bind(
            \App\Repositories\PricePlaneRepository::class,
            \App\Repositories\PriceHotelRepository::class,
            \App\Repositories\PositionRepository::class,
        );

        $this->app->singleton(\App\Services\AppService::class, function ($app) {
            return new \App\Services\AppService();
        });

        $this->app->singleton(\App\Services\PricePlaneService::class, function ($app) {
            return new \App\Services\PricePlaneService();
        });

        $this->app->singleton(\App\Services\PriceHotelService::class, function ($app) {
            return new \App\Services\PriceHotelService();
        });

        $this->app->singleton(\App\Services\PositionService::class, function ($app) {
            return new \App\Services\PositionService();
        });
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //

        Paginator::defaultView('pagination:tailwind');
    }
}
