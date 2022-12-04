<?php

namespace Typedin\LaravelCalenly;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Typedin\LaravelCalenly\Skeleton\SkeletonClass
 */
class LaravelCalenlyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-calenly';
    }
}
