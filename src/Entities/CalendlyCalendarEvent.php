<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyCalendarEvent;

class CalendlyCalendarEvent
{
    /**
     * @param  mixed  $kind
     */
    public function __construct(
     /**
      * Indicates the calendar provider the event belongs to.
      */
     public string $kind,
     /**
      * the id provided from the calendar provider for this calendar event.
      */
     public string $external_id
    ) {
    }
}
