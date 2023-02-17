<?php

namespace Typedin\LaravelCalendly\Models;

class CustomLocation
{
    /**
     * The event location doesn't fall into a standard category defined by the event host (publisher)
     * @var string $type
     */
    public string $type;

    /**
     * The location description provided by the event host (publisher)
     * @var string $location
     */
    public ?string $location;

    public function __construct(string $type, ?string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
