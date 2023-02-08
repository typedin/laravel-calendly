<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyEventInviteesCounterException extends Exception
{
    public static function nestedKeyNotFound(string $key): never
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
