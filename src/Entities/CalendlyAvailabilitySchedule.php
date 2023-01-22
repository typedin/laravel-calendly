<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyAvailabilitySchedule
{
    /**
     * A URI reference to this Availability Schedule.
     *
     * @var string
     */
    public string $uri;

    /**
     * This is the default Availability Schedule in use.
     *
     * @var bool
     */
    public bool $default;

    /**
     * The name of this Availability Schedule.
     *
     * @var string
     */
    public string $name;

    /**
     * A URI reference to a User.
     *
     * @var string
     */
    public string $user;

    /**
     * The timezone for which this Availability Schedule is originated in.
     *
     * @var string
     */
    public string $timezone;

    /**
     * The rules of this Availability Schedule.
     *
     * @var array
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
