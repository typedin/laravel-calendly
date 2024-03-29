<?php

namespace Typedin\LaravelCalendly\Models;

class OrganizationInvitation
{
    /**
     * Canonical reference (unique identifier) for the organization invitation
     */
    public string $uri;

    /**
     * Canonical reference (unique identifier) for the organization
     */
    public string $organization;

    /**
     * The email address of the person who was invited to join the organization
     */
    public string $email;

    /**
     * The status of the invitation ("pending", "accepted", or "declined")
     */
    public string $status;

    /**
     * The moment the invitation was created (e.g. “2020-01-02T03:04:05.678123Z")
     */
    public string $created_at;

    /**
     * The moment the invitation was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     */
    public string $updated_at;

    /**
     * The moment the invitation was last sent (e.g. "2020-01-02T03:04:05.678123Z")
     */
    public ?string $last_sent_at;

    /**
     * When the invitation is accepted, a reference to the user who accepted the invitation
     */
    public ?string $user;

    public function __construct(
        string $uri,
        string $organization,
        string $email,
        string $status,
        string $created_at,
        string $updated_at,
        ?string $last_sent_at,
        ?string $user,
    ) {
        $this->uri = $uri;
        $this->organization = $organization;
        $this->email = $email;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
        $this->last_sent_at = $last_sent_at;
        $this->user = $user;
    }
}
