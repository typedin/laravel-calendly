<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class CalendlyOrganizationMembershipException extends Exception
{
    /**
     * @return self
     */
    public static function nestedKeyNotFound($key): never
    {
        throw new self('Expect argument with '.$key.' key.');
    }
}
