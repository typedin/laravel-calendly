<?php

namespace Typedin\LaravelCalendly\Models;

class Profile
{
    /**
     * Indicates if the profile belongs to a "user" (individual) or "team"
     *
     * @var string
     */
    public string $type;

    /**
     * Human-readable name for the profile of the user that's associated with the event type
     *
     * @var string
     */
    public string $name;

    /**
     * The unique reference to the user associated with the profile
     *
     * @var string
     */
    public string $owner;

    public function __construct(string $type, string $name, string $owner)
    {
        $this->type = $type;
        $this->name = $name;
        $this->owner = $owner;
    }
}
