<?php

namespace Typedin\LaravelCalendly\Models;

use CalendarEvent;
use Cancellation;
use Location;

class Event
{
    /**
     * Canonical reference (unique identifier) for the resource
     *
     * @var string
     */
    public string $uri;

    /**
     * The event name
     *
     * @var string
     */
    public ?string $name;

    /**
     * Indicates if the event is "active" or "canceled"
     *
     * @var string<active|canceled>
     */
    public string $status;

    /**
     * The moment the event was scheduled to start in UTC time (e.g. "2020-01-02T03:04:05.678123Z").
     *
     * @var string
     */
    public string $start_time;

    /**
     * The moment the event was scheduled to end in UTC time (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $end_time;

    /**
     * The event type associated with this event
     *
     * @var string
     */
    public string $event_type;

    /**
     * The polymorphic base type for an event location that Calendly supports
     *
     * @var 
     */
    public Location $location;

    /** @var object */
    public object $invitees_counter;

    /**
     * The moment when the event was created (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $created_at;

    /**
     * The moment when the event was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $updated_at;

    /**
     * Event membership list
     *
     * @var array
     */
    public array $event_memberships;

    /**
     * Additional people added to an event by an invitee
     *
     * @var array
     */
    public array $event_guests;

    /**
     * Provides data pertaining to the cancellation of the Event
     *
     * @var Typedin\LaravelCalendly\Models\Cancellation
     */
    public ?Cancellation $cancellation;

    /**
     * Information about the calendar event from the calendar provider.
     *
     * @var 
     */
    public CalendarEvent $calendar_event;

    public function __construct(
        string $uri,
        ?string $name,
        string $status,
        string $start_time,
        string $end_time,
        string $event_type,
        Location $location,
        object $invitees_counter,
        string $created_at,
        string $updated_at,
        array $event_memberships,
        array $event_guests,
        ?Cancellation $cancellation,
        CalendarEvent $calendar_event,
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
        $this->cancellation = $cancellation;
        $this->calendar_event = $calendar_event;
    }
}
