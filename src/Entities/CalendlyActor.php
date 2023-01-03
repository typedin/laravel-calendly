<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyActor
{
    public function __construct(
        /**
         * The type of actor
         */
        public string $type
    ) {
    }
}
