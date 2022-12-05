<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Exceptions\CalendlyCalendarEventException;

class CalendlyCalendarEvent
{
    /**
     * Indicates the calendar provider the event belongs to.
     *  Example: google
     *
     * @var string<exchange|google|icloud|outlook|outlook_desktop>
     */
    public string $kind;

    /**
     * the id provided from the calendar provider for this calendar event.
     * Example: 8suu9k3hj00mni03ss12ba0ce0
     *
     * @var string
     */
    public string $external_id;

    public function __construct(array $args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (!array_key_exists($key, $args)) {
                CalendlyCalendarEventException::nestedKeyNotFound($key);
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
            'kind',
            'external_id',
        ]);
    }
}
