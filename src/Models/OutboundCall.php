<?php

namespace Typedin\LaravelCalendly\Models;

class OutboundCall
{
    /**
     * Indicates that the event host (publisher) will call the invitee
     * @var string $type
     */
    public string $type;

    /**
     * The phone number the event host (publisher) will use to call the invitee
     * @var string $location
     */
    public ?string $location;

    public function __construct(string $type, ?string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
