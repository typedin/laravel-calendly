<?php

namespace Typedin\LaravelCalendly\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Exceptions\CalendlyEventGuestException;
use Typedin\LaravelCalendly\traits\HasAssignableKeys;
use Typedin\LaravelCalendly\traits\HasTimestamps;

class CalendlyEventGuest
{
    use  HasTimestamps, HasAssignableKeys;

    /**
     * The event guest's email address
     * Example:test@example.com
     *
     * @var string<email>
     */
    public string $email;

    public function __construct(array $args)
    {
        $this->keys()->each(function ($key) use ($args) {
            if (! array_key_exists($key, $args)) {
                CalendlyEventGuestException::nestedKeyNotFound($key);
            }
        });

        collect($args)->each(function ($value, $key) {
            if (in_array($key, self::DATEABLE)) {
                $value = Carbon::parse($value);
            }
            $this->$key = $value;
        });
    }
}
