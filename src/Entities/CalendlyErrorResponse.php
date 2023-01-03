<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyErrorResponse
{
    public string $title;

    public string $message;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }
}
