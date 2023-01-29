<?php

namespace Typedin\LaravelCalendly\Models;

class ErrorResponse
{
    public string $title;

    public string $message;

    public ?array $details;

    public function __construct(string $title, string $message, ?array $details)
    {
        $this->title = $title;
        $this->message = $message;
        $this->details = $details;
    }
}
