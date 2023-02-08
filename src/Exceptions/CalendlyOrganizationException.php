<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyOrganizationException extends Exception
{
    public static function nestedKeyNotFound(string $key): never
    {
        throw new CalendlyOrganizationException('Expect argument with '.$key.' key.');
    }
}
