<?php

namespace Typedin\LaravelCalendly\Models;

class CalendarEvent
{
    /**
     * Indicates the calendar provider the event belongs to.
     * @var string $kind
     */
    public string $kind;

    /**
     * the id provided from the calendar provider for this calendar event.
     * @var string $external_id
     */
    public string $external_id;

    public function __construct(string $kind, string $external_id)
    {
        $this->kind = $kind;
        $this->external_id = $external_id;
    }
}
