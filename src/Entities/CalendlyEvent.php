<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyEvent
{
    /**
     * Canonical reference (unique identifier) for the resource
     */
    public string $uri;

    /**
     * The event name
     *
     * @var string|null
     */
    public string $name;

    /**
     * Indicates if the event is "active" or "canceled"
     *
     * @var string<active|canceled>
     */
    public string $status;

    /**
     * The moment the event was scheduled to start in UTC time (e.g. "2020-01-02T03:04:05.678123Z").
     */
    public string $start_time;

    /**
     * The moment the event was scheduled to end in UTC time (e.g. "2020-01-02T03:04:05.678123Z")
     */
    public string $end_time;

    /**
     * The event type associated with this event
     */
    public string $event_type;

    public $location;

    public object $invitees_counter;

    /**
     * The moment when the event was created (e.g. "2020-01-02T03:04:05.678123Z")
     */
    public string $created_at;

    /**
     * The moment when the event was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     */
    public string $updated_at;

    /**
     * Event membership list
     */
    public array $event_memberships;

    /**
     * Additional people added to an event by an invitee
     */
    public array $event_guests;

    public $calendar_event;

    public function __construct(
        string $uri,
        ?string $name,
        string $status,
        string $start_time,
        string $end_time,
        string $event_type,
        $location,
        object $invitees_counter,
        string $created_at,
        string $updated_at,
        array $event_memberships,
        array $event_guests,
        $calendar_event,
    ) {
        $this->uri = $uri;
        $this->name = $name;
        $this->status = $status;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->event_type = $event_type;
        $this->location = $location;
        $this->invitees_counter = $invitees_counter;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->event_memberships = $event_memberships;
        $this->event_guests = $event_guests;
        $this->calendar_event = $calendar_event;
    }
}
