<?php

namespace Typedin\LaravelCalendly\Http\Errors;

use Illuminate\Http\JsonResponse;

class ErrorResponse
{
    /** @var string */
    public string $title;

    /** @var string */
    public string $message;

    /** @var array */
    public array $details;

    public int $error_code;

    public function __construct(string $title, string $message, array $details, int $error_code)
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
