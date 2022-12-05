<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyCancellationException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): Exception
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
