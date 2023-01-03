<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyInviteeNoShow
{
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the no show
         */
        public string $uri,
        /**
         * Canonical reference (unique identifier) for the associated Invitee
         */
        public string $invitee,
        /**
         * The moment when the no show was created
         */
        public string $created_at
    ) {
    }
}
