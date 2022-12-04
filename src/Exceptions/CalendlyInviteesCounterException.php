<?php

namespace Typedin\LaravelCalenly\Exceptions;

use Exception;

class CalendlyInviteesCounterException extends Exception
{
    /**
     * @return self
     */
    public static function keyNotFound($key): Exception
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
