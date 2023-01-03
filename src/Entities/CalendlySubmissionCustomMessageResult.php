<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlySubmissionCustomMessageResult
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
        /**
         * Indicates if the routing form submission resulted in a custom "thank you" message.
         */
        public string $type,
        /**
         * Contains an object with custom message headline and body.
         */
        public object $value
    ) {
    }
}
