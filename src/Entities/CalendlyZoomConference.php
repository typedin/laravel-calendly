<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyZoomConference;

class CalendlyZoomConference
{
    /**
     * @param  mixed  $type
     * @param  mixed  $status
     */
    public function __construct(
     /**
      * The event location is a Zoom conference
      */
     public string $type,
     /**
      * Indicates the current status of the Zoom conference
      */
     public string $status,
     /**
      * Zoom meeting url
      */
     public ?string $join_url,
     /**
      * The conference metadata supplied by Zoom
      */
     public ?object $data
    ) {
    }
}
