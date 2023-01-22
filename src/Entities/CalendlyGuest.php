<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyGuest
{
    public string $email;

    public string $created_at;

    public string $updated_at;

    public function __construct(string $email, string $created_at, string $updated_at)
    {
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
