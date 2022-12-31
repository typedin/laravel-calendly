<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyAvailabilityRule;

class CalendlyAvailabilityRule
{
    /**
     * @param mixed $type
     */
    public function __construct(
        /**
         * The type of this Availability Rule; can be "wday" or a specific "date".
         */
        public string $type,
        /**
         * The intervals to be applied to this Rule. Each interval represents when booking a meeting is allowed. If the interval array is empty, then there is no booking availability for that day. Time is in 24h format (i.e. "17:30") and local to the timezone in the Availability Schedule.
         */
        public array $intervals
    )
    {
    }
}
