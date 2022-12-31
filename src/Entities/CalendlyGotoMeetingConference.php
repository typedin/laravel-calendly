<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyGotoMeetingConference;

class CalendlyGotoMeetingConference
{
    /**
     * @param  mixed  $type
     * @param  mixed  $status
     */
    public function __construct(
     /**
      * The event location is a GoToMeeting conference
      */
     public string $type,
     /**
      * Indicates the current status of the GoToMeeting conference
      */
     public string $status,
     /**
      * GoToMeeting conference meeting url
      */
     public ?string $join_url,
     /**
      * The conference metadata supplied by GoToMeeting
      */
     public ?object $data
 ) {
    }
}
