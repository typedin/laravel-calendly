<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInPersonMeeting;

class CalendlyInPersonMeeting
{
    /**
     * Indicates that the event will be an in-person meeting.
     *
     * @var string<physical>
     */
    public string $type;

    /**
     * The physical location specified by the event host (publisher)
     *
     * @var string
     */
    public string $location;

    public function __construct(string $type, string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
