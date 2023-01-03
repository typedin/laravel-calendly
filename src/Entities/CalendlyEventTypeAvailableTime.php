<?php

namespace Typedin\LaravelCalendly\Entities;

use number;

class CalendlyEventTypeAvailableTime
{
    /**
     * Indicates that the open time slot is "available"
     */
    public string $status;

    /**
     * Total remaining invitees for this available time. For Group Event Type, more than one invitee can book in this available time. For all other Event Types, only one invitee can book in this available time.
     */
    public number $invitees_remaining;

    /**
     * The moment the event was scheduled to start in UTC time
     */
    public string $start_time;

    /**
     * The URL of the user’s scheduling site where invitees book this event type
     */
    public string $scheduling_url;

    public function __construct(string $status, number $invitees_remaining, string $start_time, string $scheduling_url)
    {
        $this->status = $status;
        $this->invitees_remaining = $invitees_remaining;
        $this->start_time = $start_time;
        $this->scheduling_url = $scheduling_url;
    }
}
