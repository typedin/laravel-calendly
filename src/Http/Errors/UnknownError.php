<?php

namespace Typedin\LaravelCalendly\Http\Errors;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Models\ErrorResponse;

class UnknownError extends ErrorResponse
{
    public string $title;

    public string $message;

    public int $error_code;

    public function __construct(string $title, string $message, int $error_code)
    {
        $this->title = $title;
        $this->message = $message;
        $this->error_code = $error_code;
    }

    public function toJson(): JsonResponse
    {
        return response()->json(['message' => $this->message, 'title' => $this->title], $this->error_code);
    }
}
