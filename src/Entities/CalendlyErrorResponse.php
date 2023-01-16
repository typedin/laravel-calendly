<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyErrorResponse
{
    /** @var string $title */
    public string $title;

    /** @var string $message */
    public string $message;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }
}
