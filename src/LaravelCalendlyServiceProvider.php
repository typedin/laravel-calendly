<?php

namespace Typedin\LaravelCalendly;

use Illuminate\Support\ServiceProvider;
use Typedin\LaravelCalendly\Api\BaseApiClient;

class LaravelCalendlyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->app->singleton(BaseApiClient::class, function ($app) {

            return new BaseApiClient(
                config("calendly.api.key"),
                config("calendly.api.endpoint")
            );
        });

        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-calendly.php',
            'laravel-calendly',
        );
    }
}
