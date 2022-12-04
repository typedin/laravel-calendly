<?php

namespace Typedin\LaravelCalenly\Exceptions;

use Exception;

class CalendlyUserException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): Exception
    {
        throw new CalendlyUserException('Expect argument with '.$key.' key.');
    }
}
