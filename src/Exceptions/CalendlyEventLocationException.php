<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyEventLocationException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): never
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
