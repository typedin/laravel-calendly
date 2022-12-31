<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyUser;

class CalendlyUser
{
    public function __construct(
     /**
      * Canonical reference (unique identifier) for the user
      */
     public string $uri,
     /**
      * The user's name (human-readable format)
      */
     public string $name,
     /**
      * The portion of URL for the user's scheduling page (where invitees book sessions), rendered in a human-readable format
      */
     public string $slug,
     /**
      * The user's email address
      */
     public string $email,
     /**
      * The URL of the user's Calendly landing page (that lists all the user's event types)
      */
     public string $scheduling_url,
     /**
      * The time zone to use when presenting time to the user
      */
     public string $timezone,
     /**
      * The URL of the user's avatar (image)
      */
     public ?string $avatar_url,
     /**
      * The moment when the user's record was created (e.g. "2020-01-02T03:04:05.678123Z")
      */
     public string $created_at,
     /**
      * The moment when the user's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
      */
     public string $updated_at,
     /**
      * A unique reference to the user's current organization
      */
     public string $current_organization
    ) {
    }
}
