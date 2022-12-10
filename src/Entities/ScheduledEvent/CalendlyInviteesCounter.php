<?php

namespace Typedin\LaravelCalendly\Entities\ScheduledEvent;

use Typedin\LaravelCalendly\Entities\CalendlyBaseClass;
use Typedin\LaravelCalendly\Exceptions\CalendlyInviteesCounterException;

class CalendlyInviteesCounter extends CalendlyBaseClass
{
    /**
     * Total invitees for an event, including invitees that have canceled
     *
     * @var int<total>
     */
    public int $total;

    /**
     * Total invitees for an event that have not canceled
     *
     * @var int<active>
     */
    public int $active;

    /**
     * Maximum number of active invitees that can book the event
     *
     *
     * @var int<limit>
     */
    public int $limit;

    public function __construct($args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyInviteesCounterException::keyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            $this->$key = $value;
        });
    }
}