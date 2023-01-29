<?php

namespace Typedin\LaravelCalendly\Models;

class InPersonMeeting
{
    /**
     * Indicates that the event will be an in-person meeting.
     */
    public string $type;

    /**
     * The physical location specified by the event host (publisher)
     */
    public string $location;

    public function __construct(string $type, string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
