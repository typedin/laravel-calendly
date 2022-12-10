<?php

namespace Typedin\LaravelCalendly\Entities\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\CalendlyBaseClass;
use Typedin\LaravelCalendly\Exceptions\CalendlyEventGuestException;
use Typedin\LaravelCalendly\traits\HasTimestamps;

class CalendlyEventGuest extends CalendlyBaseClass
{
    use  HasTimestamps;

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
