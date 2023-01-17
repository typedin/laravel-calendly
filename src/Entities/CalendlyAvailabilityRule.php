<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyAvailabilityRule
{
    /**
     * The type of this Availability Rule; can be "wday" or a specific "date".
     * @var string<wday|date> $type
     */
    public string $type;

    /**
     * The intervals to be applied to this Rule. Each interval represents when booking a meeting is allowed. If the interval array is empty, then there is no booking availability for that day. Time is in 24h format (i.e. "17:30") and local to the timezone in the Availability Schedule.
     * @var array $intervals
     */
    public array $intervals;

    public function __construct(string $type, array $intervals)
    {
        $this->type = $type;
        $this->intervals = $intervals;
    }
}
