<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyCalendarEventException extends Exception
{
    public static function nestedKeyNotFound(string $key): never
    {
        throw new CalendlyUserException('Expect argument with '.$key.' key.');
    }
}
