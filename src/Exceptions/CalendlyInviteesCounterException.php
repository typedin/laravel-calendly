<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyInviteesCounterException extends Exception
{
    public static function keyNotFound(string $key): never
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
