<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyErrorResponse
{
    public function __construct(public string $title, public string $message)
    {
    }
}
