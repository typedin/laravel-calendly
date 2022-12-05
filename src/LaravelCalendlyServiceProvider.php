<?php

namespace Typedin\LaravelCalendly;

use Illuminate\Support\ServiceProvider;

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
            __DIR__ . '/../config/laravel-calendly.php',
            "laravel-calendly",
        );
    }
}
