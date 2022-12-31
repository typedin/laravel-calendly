<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInboundCall;

class CalendlyInboundCall
{
    /**
     * @param mixed $type
     */
    public function __construct(
        /**
         * Indicates that the invitee will call the event host
         */
        public string $type,
        /**
         * The phone number the invitee will use to call the event host (publisher)
         */
        public string $location
    )
    {
    }
}
