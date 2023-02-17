<?php

namespace Typedin\LaravelCalendly\Models;

class CustomLocation
{
    /**
     * The event location doesn't fall into a standard category defined by the event host (publisher)
     */
    public string $type;

    /**
     * The location description provided by the event host (publisher)
     */
    public ?string $location;

    public function __construct(string $type, ?string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
