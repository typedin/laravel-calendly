<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyScheduledEventException extends Exception
{
    /**
     * @return string
     */
    public static function keyNotFound($key): never
    {
        throw new CalendlyScheduledEventException('Expect argument with '.$key.' key.');
    }
}
