<?php

namespace Typedin\LaravelCalendly\Models;

class InboundCall
{
    /**
     * Indicates that the invitee will call the event host
     */
    public string $type;

    /**
     * The phone number the invitee will use to call the event host (publisher)
     */
    public string $location;

    public function __construct(string $type, string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
