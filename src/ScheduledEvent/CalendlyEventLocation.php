<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Exceptions\CalendlyEventLocationException;

class CalendlyEventLocation
{
    /**
     * The physical location specified by the event host (publisher).
     * Example: Calendly Office
     *
     * @var string
     */
    public String $location;

    /**
     * Indicates that the event will be an in-person meeting.
     * allowed value: physical
     *
     * @var string
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

    /**
     * @return Collection<TKey,TValue>
     */
    private function keys(): Collection
    {
        return collect([
            'type',
            'location',
        ]);
    }
}
