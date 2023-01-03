<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyRoutingForm
{
    /**
     * @param  mixed  $status
     */
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the routing form.
         */
        public string $uri,
        /**
         * The URI of the organization that's associated with the routing form.
         */
        public string $organization,
        /**
         * The routing form name (in human-readable format).
         */
        public string $name,
        /**
         * Indicates if the form is in "draft" or "published" status.
         */
        public string $status,
        /**
         * An ordered collection of Routing Form non-deleted questions.
         */
        public array $questions,
        /**
         * The moment the routing form was created.
         */
        public string $created_at,
        /**
         * The moment when the routing form was last updated.
         */
        public string $updated_at
    ) {
    }
}
