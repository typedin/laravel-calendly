<?php

namespace Typedin\LaravelCalendly\Models;

class Guest
{
    /** @var string $email */
    public string $email;

    /** @var string $created_at */
    public string $created_at;

    /** @var string $updated_at */
    public string $updated_at;

    public function __construct(string $email, string $created_at, string $updated_at)
    {
        $this->email = $email;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
