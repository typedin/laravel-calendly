<?php

namespace Typedin\LaravelCalendly\Models;

class AvailabilityRule
{
    /**
     * The type of this Availability Rule; can be "wday" or a specific "date".
     */
    public string $type;

    /**
     * The intervals to be applied to this Rule. Each interval represents when booking a meeting is allowed. If the interval array is empty, then there is no booking availability for that day. Time is in 24h format (i.e. "17:30") and local to the timezone in the Availability Schedule.
     */
    public array $intervals;

    /**
     * The day of the week for which this Rule should be applied to.
     */
    public ?string $wday;

    /**
     * A specific date in the future that this should be applied to (i.e. "2030-12-31").
     */
    public ?string $date;

    public function __construct(string $type, array $intervals, ?string $wday, ?string $date)
    {
        $this->type = $type;
        $this->intervals = $intervals;
        $this->wday = $wday;
        $this->date = $date;
    }
}
