<?php

namespace Typedin\LaravelCalendly\Models;

class InviteeSpecifiedLocation
{
    /**
     * The event location selected by the invitee
     * @var string $type
     */
    public string $type;

    /**
     * The event location description provided by the invitee
     * @var string $location
     */
    public string $location;

    public function __construct(string $type, string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
