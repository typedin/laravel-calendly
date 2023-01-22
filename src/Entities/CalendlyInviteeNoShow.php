<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyInviteeNoShow
{
    /**
     * Canonical reference (unique identifier) for the no show
     * @var string
     */
    public string $uri;

    /**
     * Canonical reference (unique identifier) for the associated Invitee
     * @var string
     */
    public string $invitee;

    /**
     * The moment when the no show was created
     * @var string
     */
    public string $created_at;

    public function __construct(string $uri, string $invitee, string $created_at)
    {
        $this->uri = $uri;
        $this->invitee = $invitee;
        $this->created_at = $created_at;
    }
}
