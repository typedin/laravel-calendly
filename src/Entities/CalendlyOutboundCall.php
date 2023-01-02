<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyOutboundCall;

class CalendlyOutboundCall
{
    /**
     * Indicates that the event host (publisher) will call the invitee
     * @var string<outbound_call> $type
     */
    public string $type;

    /**
     * The phone number the event host (publisher) will use to call the invitee
     * @var string|null $location
     */
    public string $location;

    public function __construct(string $type, ?string $location)
    {
        $this->type = $type;
        $this->location = $location;
    }
}
