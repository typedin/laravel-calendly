<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInviteeSpecifiedLocation;

class CalendlyInviteeSpecifiedLocation
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
     /**
      * The event location selected by the invitee
      */
     public string $type,
     /**
      * The event location description provided by the invitee
      */
     public string $location
    ) {
    }
}
