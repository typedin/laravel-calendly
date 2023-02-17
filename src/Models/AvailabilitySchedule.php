<?php

namespace Typedin\LaravelCalendly\Models;

class AvailabilitySchedule
{
    /**
     * A URI reference to this Availability Schedule.
     * @var string $uri
     */
    public string $uri;

    /**
     * This is the default Availability Schedule in use.
     * @var bool $default
     */
    public bool $default;

    /**
     * The name of this Availability Schedule.
     * @var string $name
     */
    public string $name;

    /**
     * A URI reference to a User.
     * @var string $user
     */
    public string $user;

    /**
     * The timezone for which this Availability Schedule is originated in.
     * @var string $timezone
     */
    public string $timezone;

    /**
     * The rules of this Availability Schedule.
     * @var array $rules
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
