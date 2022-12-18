<?php

namespace Typedin\LaravelCalendly;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Typedin\LaravelCalendly\Skeleton\SkeletonClass
 */
class LaravelCalendlyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-calendly';
    }
}
