<?php

namespace Typedin\LaravelCalenly\ScheduledEvent;

use Illuminate\Support\Collection;
use Typedin\LaravelCalenly\Exceptions\CalendlyEventLocationException;

class CalendlyEventLocation
{
    public function __construct($args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (!array_key_exists($key, $args)) {
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
