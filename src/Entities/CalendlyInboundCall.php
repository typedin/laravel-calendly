<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyInboundCall
{
    /**
     * Indicates that the invitee will call the event host
     *
     * @var string<inbound_call>
     */
    public string $type;

    /**
     * The phone number the invitee will use to call the event host (publisher)
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
