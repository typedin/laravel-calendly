<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyCalendarEvent
{
    /**
     * Indicates the calendar provider the event belongs to.
     *
     * @var string<exchange|google|icloud|outlook|outlook_desktop>
     */
    public string $kind;

    /**
     * the id provided from the calendar provider for this calendar event.
     */
    public string $external_id;

    public function __construct(string $kind, string $external_id)
    {
        $this->kind = $kind;
        $this->external_id = $external_id;
    }
}
