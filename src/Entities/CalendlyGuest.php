<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyGuest;

class CalendlyGuest
{
    public function __construct(public string $email, public string $created_at, public string $updated_at)
    {
    }
}
