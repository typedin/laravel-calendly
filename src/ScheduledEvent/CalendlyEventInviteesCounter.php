<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Typedin\LaravelCalendly\Exceptions\CalendlyEventInviteesCounterException;
use Typedin\LaravelCalendly\traits\HasAssignableKeys;

class CalendlyEventInviteesCounter
{
    use HasAssignableKeys;

    public int $total;

    public int $active;

    public int $limit;

    public function __construct($args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyEventInviteesCounterException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            $this->$key = $value;
        });
    }
}
