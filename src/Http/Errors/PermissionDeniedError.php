<?php

namespace Typedin\LaravelCalendly\Http\Errors;

use Typedin\LaravelCalendly\Models\ErrorResponse;

class PermissionDeniedError extends ErrorResponse
{
    public string $title;

    public string $message;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }
}
