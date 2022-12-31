<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInPersonMeeting;

class CalendlyInPersonMeeting
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
     /**
      * Indicates that the event will be an in-person meeting.
      */
     public string $type,
     /**
      * The physical location specified by the event host (publisher)
      */
     public string $location
    ) {
    }
}
