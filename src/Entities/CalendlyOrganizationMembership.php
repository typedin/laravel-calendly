<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyOrganizationMembership
{
    /**
     * @param  mixed  $role
     */
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the membership
         */
        public string $uri,
        /**
         * The user's role in the organization
         */
        public string $role,
        /**
         * Information about the user.
         */
        public object $user,
        /**
         * A unique reference to the organization
         */
        public string $organization,
        /**
         * The moment when the membership record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $updated_at,
        /**
         * The moment when the membership record was created (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $created_at
    ) {
    }
}
