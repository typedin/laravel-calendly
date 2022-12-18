<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class ApiClientException extends Exception
{
    /**
     * @return self
     */
    public static function ApiKeyNotFound(): never
    {
        throw new ApiClientException('Expect an API key. None found.');
    }

    /**
     * @return self
     */
    public static function ApiEndpointNotFound(): never
    {
        throw new ApiClientException('Expect an API endpoint. None found.');
    }
}
