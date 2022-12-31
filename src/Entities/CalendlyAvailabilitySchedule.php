<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyAvailabilitySchedule;

class CalendlyAvailabilitySchedule
{
    public function __construct(
     /**
      * A URI reference to this Availability Schedule.
      */
     public string $uri,
     /**
      * This is the default Availability Schedule in use.
      */
     public bool $default,
     /**
      * The name of this Availability Schedule.
      */
     public string $name,
     /**
      * A URI reference to a User.
      */
     public string $user,
     /**
      * The timezone for which this Availability Schedule is originated in.
      */
     public string $timezone,
     /**
      * The rules of this Availability Schedule.
      */
     public array $rules
 ) {
    }
}
