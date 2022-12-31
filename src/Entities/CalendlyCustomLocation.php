<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyCustomLocation;

class CalendlyCustomLocation
{
    /**
     * @param mixed $type
     */
    public function __construct(
        /**
         * The event location doesn't fall into a standard category defined by the event host (publisher)
         */
        public string $type,
        /**
         * The location description provided by the event host (publisher)
         */
        public ?string $location
    )
    {
    }
}
