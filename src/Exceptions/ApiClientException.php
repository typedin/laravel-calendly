<?php

namespace Typedin\LaravelCalendly\Exceptions;

use Exception;

class ApiClientException extends Exception
{
    /**
     * @return self
     */
    public static function ApiKeyNotFound(): Exception
    {
        throw new ApiClientException('Expect an API key. None found.');
    }

    /**
     * @return self
     */
    public static function ApiEndpointNotFound(): Exception
    {
        throw new ApiClientException('Expect an API endpoint. None found.');
    }
}
