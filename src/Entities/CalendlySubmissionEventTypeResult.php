<?php

namespace Typedin\LaravelCalendly\Entities\CalendlySubmissionEventTypeResult;

class CalendlySubmissionEventTypeResult
{
    /**
     * @param mixed $type
     */
    public function __construct(
        /**
         * Indicates that the routing form submission resulted in a redirect to an event type booking page.
         */
        public string $type,
        /**
         * A reference to the event type resource.
         */
        public string $value
    )
    {
    }
}
