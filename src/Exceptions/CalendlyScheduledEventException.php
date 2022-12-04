<?php

namespace Typedin\LaravelCalenly\Exceptions;

use Exception;

class CalendlyScheduledEventException extends Exception
{
    /**
     * @return string
     */
    public static function keyNotFound($key): Exception
    {
        throw new CalendlyScheduledEventException('Expect argument with '.$key.' key.');
    }
}
