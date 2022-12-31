<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyOutboundCall;

class CalendlyOutboundCall
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
     /**
      * Indicates that the event host (publisher) will call the invitee
      */
     public string $type,
     /**
      * The phone number the event host (publisher) will use to call the invitee
      */
     public ?string $location
    ) {
    }
}
