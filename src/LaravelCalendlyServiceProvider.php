<?php

namespace Typedin\LaravelCalendly;

use Illuminate\Contracts\Foundation\Application;
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
        $this->app->bind(BaseApiClient::class, function (Application $app) {
            return new BaseApiClient(
                config('calendly.api.key'),
                config('calendly.api.endpoint')
            );
        });
    }
}
