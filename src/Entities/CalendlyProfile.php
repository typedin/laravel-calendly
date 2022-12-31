<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyProfile;

class CalendlyProfile
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
     /**
      * Indicates if the profile belongs to a "user" (individual) or "team"
      */
     public string $type,
     /**
      * Human-readable name for the profile of the user that's associated with the event type
      */
     public string $name,
     /**
      * The unique reference to the user associated with the profile
      */
     public string $owner
    ) {
    }
}
