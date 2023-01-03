<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyUserBusyTime
{
    /**
     * @param  mixed  $type
     */
    public function __construct(
        /**
         * Indicates whether the scheduled event is internal or external
         */
        public string $type,
        /**
         * The start time of the scheduled event in UTC time
         */
        public string $start_time,
        /**
         * The end time of the scheduled event in UTC time
         */
        public string $end_time
    ) {
    }
}
