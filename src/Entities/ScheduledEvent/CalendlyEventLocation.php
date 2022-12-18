<?php

namespace Typedin\LaravelCalendly\Entities\ScheduledEvent;

use Typedin\LaravelCalendly\Entities\CalendlyBaseClass;
use Typedin\LaravelCalendly\Exceptions\CalendlyEventLocationException;

class CalendlyEventLocation extends CalendlyBaseClass
{
    /**
     * The physical location specified by the event host (publisher).
     * Example: Calendly Office
     */
    public String $location;

    /**
     * Indicates that the event will be an in-person meeting.
     * allowed value: physical
     */
    public String $type;

    public function __construct($args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyEventLocationException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            $this->$key = $value;
        });
    }
}
