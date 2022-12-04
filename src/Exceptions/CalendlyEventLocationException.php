<?php

namespace Typedin\LaravelCalenly\Exceptions;

use Exception;

class CalendlyEventLocationException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): Exception
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
