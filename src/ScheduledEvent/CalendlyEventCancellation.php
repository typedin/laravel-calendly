<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Typedin\LaravelCalendly\Exceptions\CalendlyCancellationException;
use Typedin\LaravelCalendly\traits\HasAssignableKeys;

/**
 * Provides data pertaining to the cancellation of the Event
 */
class CalendlyEventCancellation
{
    use   HasAssignableKeys;

    /**
     * Name of the person whom canceled
     *
     * @var canceled_by string
     */
    public string $canceled_by;

    /**
     * Reason that the cancellation occurred
     *
     * @var string<reason>
     */
    public string $reason;

    /**
     * @var string<host|invitee>
     */
    public string $canceler_type;

    public function __construct($args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyCancellationException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            $this->$key = $value;
        });
    }
}
