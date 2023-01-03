<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyEntry
{
    public function __construct(
        public string $action,
        public object $details,
        public string $fully_qualified_name,
        public string $uri,
        public string $namespace,
        /**
         * The date and time of the entry (format: "2020-01-02T03:04:05.678Z").
         */
        public string $occurred_at,
        public string $organization
    ) {
    }
}
