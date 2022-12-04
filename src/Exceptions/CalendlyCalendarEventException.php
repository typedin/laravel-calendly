<?php

namespace Typedin\LaravelCalenly\Exceptions;

use Exception;

class CalendlyCalendarEventException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): Exception
    {
        throw new CalendlyUserException('Expect argument with '.$key.' key.');
    }
}
