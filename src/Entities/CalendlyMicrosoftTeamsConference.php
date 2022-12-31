<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyMicrosoftTeamsConference;

class CalendlyMicrosoftTeamsConference
{
    /**
     * @param mixed $type
     * @param mixed $status
     */
    public function __construct(
        /**
         * The event location is a Zoom conference
         */
        public string $type,
        /**
         * Indicates the current status of the Microsoft Teams conference
         */
        public string $status,
        /**
         * Microsoft Teams meeting url
         */
        public ?string $join_url,
        /**
         * The conference metadata supplied by Microsoft Teams
         */
        public ?object $data
    )
    {
    }
}
