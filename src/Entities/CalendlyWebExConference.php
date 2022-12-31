<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyWebExConference;

class CalendlyWebExConference
{
    /**
     * @param mixed $type
     * @param mixed $status
     */
    public function __construct(
        /**
         * The event location is a WebEx conference
         */
        public string $type,
        /**
         * Indicates the current status of the WebEx conference
         */
        public string $status,
        /**
         * WebEx conference meeting url
         */
        public ?string $join_url,
        /**
         * The conference metadata supplied by GoToMeeting
         */
        public ?object $data
    )
    {
    }
}
