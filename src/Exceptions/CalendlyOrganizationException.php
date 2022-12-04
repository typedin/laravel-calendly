<?php

namespace Typedin\LaravelCalenly\Exceptions;

use Exception;

class CalendlyOrganizationException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): Exception
    {
        throw new CalendlyOrganizationException('Expect argument with '.$key.' key.');
    }
}
