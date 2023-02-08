<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class ApiClientException extends Exception
{
    public static function ApiKeyNotFound(): never
    {
        throw new ApiClientException('Expect an API key. None found.');
    }

    public static function ApiEndpointNotFound(): never
    {
        throw new ApiClientException('Expect an API endpoint. None found.');
    }
}
