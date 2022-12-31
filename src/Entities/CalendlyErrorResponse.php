<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyErrorResponse;

class CalendlyErrorResponse
{
    public function __construct(public string $title, public string $message)
    {
    }
}
