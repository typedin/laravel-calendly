<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyOrganizationException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): never
    {
        throw new CalendlyOrganizationException('Expect argument with '.$key.' key.');
    }
}
