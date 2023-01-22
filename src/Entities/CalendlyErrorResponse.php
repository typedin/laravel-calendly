<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyErrorResponse
{
    /** @var string */
    public string $title;

    /** @var string */
    public string $message;

    public function __construct(string $title, string $message)
    {
        $this->title = $title;
        $this->message = $message;
    }
}
