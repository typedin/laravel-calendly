<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyCancellation;

class CalendlyCancellation
{
    /**
     * @param  mixed  $canceler_type
     */
    public function __construct(
     /**
      * Name of the person whom canceled
      */
     public string $canceled_by,
     /**
      * Reason that the cancellation occurred
      */
     public ?string $reason,
     public string $canceler_type
 ) {
    }
}
