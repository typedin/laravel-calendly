<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyScheduledEventException extends Exception
{
    public static function keyNotFound(string $key): never
    {
        throw new CalendlyScheduledEventException('Expect argument with '.$key.' key.');
    }
}
