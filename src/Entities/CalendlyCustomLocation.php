<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyCustomLocation
{
    /**
     * The event location doesn't fall into a standard category defined by the event host (publisher)
     *
     * @var string<custom>
     */
    public string $type;

    /**
     * The location description provided by the event host (publisher)
     *
     * @var string|null
     */
    public string $location;

    public function __construct(string $type, ?string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
