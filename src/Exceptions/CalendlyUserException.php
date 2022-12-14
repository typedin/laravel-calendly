<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyUserException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): never
    {
        throw new CalendlyUserException('Expect argument with '.$key.' key.');
    }
}
