<?php

namespace Typedin\LaravelCalendly;

use Illuminate\Support\ServiceProvider;
use Typedin\LaravelCalendly\Api\BaseApiClient;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;

class LaravelCalendlyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/laravel-calendly.php' => config_path('laravel-calendly.php'),
        ]);
    }

    /**
     * Register the application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-calendly.php',
            'laravel-calendly',
        );

        $this->app->bind(CalendlyApiInterface::class, BaseApiClient::class);
    }
}
