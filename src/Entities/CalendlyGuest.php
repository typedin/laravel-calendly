<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyGuest
{
    public function __construct(public string $email, public string $created_at, public string $updated_at)
    {
    }
}
