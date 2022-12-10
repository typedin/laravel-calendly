<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Exceptions\CalendlyScheduledEventException;
use Typedin\LaravelCalendly\traits\HasAssignableKeys;
use Typedin\LaravelCalendly\traits\HasTimestamps;
use Typedin\LaravelCalendly\traits\HasUuid;

class CalendlyScheduledEvent
{
    use HasUuid, HasTimestamps, HasAssignableKeys;

    /**
     * The event type associated with this event
     * Example:https://api.calendly.com/event_types/GBGBDCAADAEDCRZ2
     *
     * @var string<uuid>
     */
    public string $event_type;

    /**
     * The event name
     * Example:15 Minute Meeting
     *
     * @var string<name>
     */
    public string $name;

    /*
    * Indicates if the event is "active" or "canceled"
    * Allowed values:activecanceled
    *
    * @var string<active | canceled>
    */
    public string $status;

    /*
    * Canonical reference (unique identifier) for the event
    * Example:https://api.calendly.com/event/AAAAAAAAAAAAAAAA
    *
    * @var string<url>
    */
    public string $uri;

    public array $calendar_event;

    public array $event_guests;

    public array $event_memberships;

    public array $invitees_counter;

    public array $location;

    /**
     * The moment the event was scheduled to end in UTC time (e.g. "2020-01-02T03:04:05.678123Z")
     * Example: 2020-01-02T03:04:05.678123Z
     *
     * @var Carbon<end_time>
     */
    public Carbon $end_time;

    /**
     * The moment the event was scheduled to start in UTC time (e.g. "2020-01-02T03:04:05.678123Z")
     * Example: 2020-01-02T03:04:05.678123Z
     *
     * @var Carbon<start_time>
     */
    public Carbon $start_time;

    public function __construct(array $args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyScheduledEventException::keyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            if (in_array($key, array_merge(['start_time', 'end_time'], self::DATEABLE))) {
                $value = Carbon::parse($value);
            }
            $this->$key = $value;
        });

        $this->uuid = $this->extractUUID('/scheduled_events/', $args['uri']);
    }
}
