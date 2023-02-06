<?php

namespace Typedin\LaravelCalendly\Models;

use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    public string $title;

    public string $message;

    public ?array $details;

    public int $error_code;

    public function __construct(string $title, string $message, int $error_code, ?array $details)
    {
        $this->title = $title;
        $this->message = $message;
        $this->details = $details;
        $this->error_code = $error_code;
    }

    public function toJson(): JsonResponse
    {
        return response()->json(['message' => $this->message, 'title' => $this->title, 'details' => $this->details], $this->error_code);
    }
}
