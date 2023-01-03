<?php

namespace Typedin\LaravelCalendly\Entities;

use number;

class CalendlyEventTypeAvailableTime
{
    /**
     * Total remaining invitees for this available time. For Group Event Type, more than one invitee can book in this available time. For all other Event Types, only one invitee can book in this available time.
     */
    public number $invitees_remaining;

    public function __construct(/**
     * Indicates that the open time slot is "available"
     */
    public string $status, number $invitees_remaining, /**
     * The moment the event was scheduled to start in UTC time
     */
    public string $start_time, /**
     * The URL of the user’s scheduling site where invitees book this event type
     */
    public string $scheduling_url)
    {
        $this->invitees_remaining = $invitees_remaining;
    }
}
