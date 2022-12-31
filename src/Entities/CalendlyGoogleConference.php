<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyGoogleConference;

class CalendlyGoogleConference
{
    /**
     * @param  mixed  $type
     * @param  mixed  $status
     */
    public function __construct(
     /**
      * The event location is a Google Meet or Hangouts conference
      */
     public string $type,
     /**
      * Indicates the current status of the Google conference
      */
     public string $status,
     /**
      * Google conference meeting url
      */
     public ?string $join_url
    ) {
    }
}
