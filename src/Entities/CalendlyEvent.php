<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyEvent
{
    /**
     * @param  mixed  $status
     */
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the resource
         */
        public string $uri,
        /**
         * The event name
         */
        public ?string $name,
        /**
         * Indicates if the event is "active" or "canceled"
         */
        public string $status,
        /**
         * The moment the event was scheduled to start in UTC time (e.g. "2020-01-02T03:04:05.678123Z").
         */
        public string $start_time,
        /**
         * The moment the event was scheduled to end in UTC time (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $end_time,
        /**
         * The event type associated with this event
         */
        public string $event_type,
        public $location,
        public object $invitees_counter,
        /**
         * The moment when the event was created (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $created_at,
        /**
         * The moment when the event was last updated (e.g. "2020-01-02T03:04:05.678123Z")
         */
        public string $updated_at,
        /**
         * Event membership list
         */
        public array $event_memberships,
        /**
         * Additional people added to an event by an invitee
         */
        public array $event_guests,
        public $calendar_event
    ) {
    }
}
