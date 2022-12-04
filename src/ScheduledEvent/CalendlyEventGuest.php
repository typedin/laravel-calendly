<?php

namespace Typedin\LaravelCalenly\ScheduledEvent;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Typedin\LaravelCalenly\Exceptions\CalendlyEventGuestException;

class CalendlyEventGuest
{
    /**
     * The event guest's email address
     * Example:test@example.com
     *
     * @var string<email>
     */
    public string $email;

    /**
     * The moment when the event guest's record was created (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-01-02T03:04:05.678123Z
     *
     * @var Carbon<created_at>
     */
    public Carbon $created_at;

    /**
     * The moment when the event guest's record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     * Example:2019-08-07T06:05:04.321123Z
     *
     * @var Carbon<updated_at>
     */
    public Carbon $updated_at;

    const DATEABLE = ['created_at', 'updated_at'];

    public function __construct($response_args)
    {
        $this->keys()->each(function ($key) use ($response_args) {
            if (!array_key_exists($key, $response_args)) {
                CalendlyEventGuestException::nestedKeyNotFound($key);
            }
        });

        collect($response_args)->each(function ($value, $key) {
            if (in_array($key, self::DATEABLE)) {
                $value = Carbon::parse($value);
            }
            $this->$key = $value;
        });
    }

    /**
     * @return Collection<TKey,TValue>
     */
    private function keys(): Collection
    {
        return collect([
            'email',
            'created_at',
            'updated_at',
        ]);
    }
}
