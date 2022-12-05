<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Exceptions\CalendlyScheduledEventException;
use Typedin\LaravelCalendly\LaravelCalendly;

class CalendlyScheduledEvent
{
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

    /**
     * The unique identifier in Calendly system
     * Example:AAAA-AAAA-AAAA-AAAA
     *
     * @var string<uuid>
     */
    public string $uuid;

    public array $calendar_event;

    public array $event_guests;

    public array $event_memberships;

    public array $invitees_counter;

    public array $location;

    /**
     * The moment when the event's record was created (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-01-02T03:04:05.678123Z
     *
     * @var Carbon<created_at>
     */
    public Carbon $created_at;

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

    /**
     * The moment when the event's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-08-07T06:05:04.321123Z
     *
     * @var Carbon<updated_at>
     */
    public Carbon $updated_at;

    public const DATEABLE = ['created_at', 'updated_at', 'start_time', 'end_time'];

    public function __construct(array $args, string $base_url)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (!array_key_exists($key, $args)) {
                CalendlyScheduledEventException::keyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            if (in_array($key, self::DATEABLE)) {
                $value = Carbon::parse($value);
            }
            $this->$key = $value;
        });

        $this->uuid = str_replace($base_url . '/scheduled_events/', '', $args['uri']);
    }

    /**
     * @return Collection<TKey,TValue>
     */
    private function keys(): Collection
    {
        return collect([
            'calendar_event',
            'created_at',
            'end_time',
            'event_guests',
            'event_memberships',
            'event_type',
            'invitees_counter',
            'location',
            'name',
            'start_time',
            'status',
            'updated_at',
            'uri',
            // "cancellation", // not required
        ]);
    }
}
