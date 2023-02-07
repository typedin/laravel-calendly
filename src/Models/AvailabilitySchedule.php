<?php

namespace Typedin\LaravelCalendly\Models;

class AvailabilitySchedule
{
    /**
     * A URI reference to this Availability Schedule.
     */
    public string $uri;

    /**
     * This is the default Availability Schedule in use.
     */
    public bool $default;

    /**
     * The name of this Availability Schedule.
     */
    public string $name;

    /**
     * A URI reference to a User.
     */
    public string $user;

    /**
     * The timezone for which this Availability Schedule is originated in.
     */
    public string $timezone;

    /**
     * The rules of this Availability Schedule.
     */
    public array $rules;

    public function __construct(string $uri, bool $default, string $name, string $user, string $timezone, array $rules)
    {
        $this->uri = $uri;
        $this->default = $default;
        $this->name = $name;
        $this->user = $user;
        $this->timezone = $timezone;
        $this->rules = $rules;
    }
}
