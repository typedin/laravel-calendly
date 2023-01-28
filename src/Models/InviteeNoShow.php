<?php

namespace Typedin\LaravelCalendly\Models;

class InviteeNoShow
{
    /**
     * Canonical reference (unique identifier) for the no show
     */
    public string $uri;

    /**
     * Canonical reference (unique identifier) for the associated Invitee
     */
    public string $invitee;

    /**
     * The moment when the no show was created
     */
    public string $created_at;

    public function __construct(string $uri, string $invitee, string $created_at)
    {
        $this->uri = $uri;
        $this->invitee = $invitee;
        $this->created_at = $created_at;
    }
}
