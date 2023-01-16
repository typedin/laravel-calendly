<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyInviteeSpecifiedLocation
{
    /**
     * The event location selected by the invitee
     *
     * @var string<ask_invitee>
     */
    public string $type;

    /**
     * The event location description provided by the invitee
     *
     * @var string
     */
    public string $location;

    public function __construct(string $type, string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
