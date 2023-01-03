<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyOrganizationInvitation
{
    /**
     * @param  mixed  $status
     */
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the organization invitation
         */
        public string $uri,
        /**
         * Canonical reference (unique identifier) for the organization
         */
        public string $organization,
        /**
         * The email address of the person who was invited to join the organization
         */
        public string $email,
        /**
         * The status of the invitation ("pending", "accepted", or "declined")
         */
        public string $status,
        /**
         * The moment the invitation was created (e.g. “2020-01-02T03:04:05.678123Z")
         */
        public string $created_at,
        /**
         * The moment the invitation was last updated (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $updated_at,
        /**
         * The moment the invitation was last sent (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public ?string $last_sent_at
    ) {
    }
}
