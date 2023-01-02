<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyGuest;

class CalendlyGuest
{
    /** @var string */
    public string $email;

    /** @var string */
    public string $created_at;

    /** @var string */
    public string $updated_at;

    public function __construct(string $email, string $created_at, string $updated_at)
    {
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
