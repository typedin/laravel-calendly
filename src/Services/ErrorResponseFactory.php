<?php

namespace Typedin\LaravelCalendly\Services;

use Illuminate\Http\Client\Response;
use Typedin\LaravelCalendly\Http\Errors\NotFoundError;
use Typedin\LaravelCalendly\Http\Errors\PermissionDeniedError;
use Typedin\LaravelCalendly\Http\Errors\UnauthenticatedError;
use Typedin\LaravelCalendly\Http\Errors\UnknownError;
use Typedin\LaravelCalendly\Models\ErrorResponse;

class ErrorResponseFactory
{
    public readonly ErrorResponse $errorResponse;

    public function __construct(Response $response)
    {
        $this->errorResponse = $this->createErrorResponseClass(json_decode($response->body(), true), $response->status());
    }

    /**
     * @param  array<int,mixed>  $body
     */
    private function createErrorResponseClass(array $body, int $status_code): ErrorResponse
    {
        if ($status_code == 401) {
            return new UnauthenticatedError(
                title:$body['title'],
                message:$body['message'],
                details:$body['details'],
                error_code:$status_code
            );
        }
        if ($status_code == 403) {
            return new PermissionDeniedError(
                title:$body['title'],
                message:$body['message'],
                details:$body['details'],
                error_code:$status_code
            );
        }

        if ($status_code == 404) {
            return new NotFoundError(
                title:$body['title'],
                message:$body['message'],
                details:$body['details'],
                error_code:$status_code
            );
        }

        if ($status_code == 500) {
            return new UnknownError(
                title:$body['title'],
                message:$body['message'],
                details:$body['details'],
                error_code:$status_code
            );
        }

        return  new ErrorResponse(
            title:$body['title'],
            message:$body['message'],
            details:$body['details'] ?? [],
            error_code:$status_code
        );
    }
}
