<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyInviteesCounterException extends Exception
{
    /**
     * @return self
     */
    public static function keyNotFound($key): never
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
