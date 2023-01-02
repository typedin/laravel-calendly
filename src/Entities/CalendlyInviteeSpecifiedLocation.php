<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInviteeSpecifiedLocation;

class CalendlyInviteeSpecifiedLocation
{
    /**
     * The event location selected by the invitee
     * @var string<ask_invitee> $type
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
