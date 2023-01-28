<?php

namespace Typedin\LaravelCalendly\Models;

class OrganizationMembership
{
    /**
     * Canonical reference (unique identifier) for the membership
     *
     * @var string
     */
    public string $uri;

    /**
     * The user's role in the organization
     *
     * @var string<user|admin|owner>
     */
    public string $role;

    /**
     * Information about the user.
     *
     * @var object
     */
    public object $user;

    /**
     * A unique reference to the organization
     *
     * @var string
     */
    public string $organization;

    /**
     * The moment when the membership record was last updated (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $updated_at;

    /**
     * The moment when the membership record was created (e.g. "2020-01-02T03:04:05.678123Z")
     *
     * @var string
     */
    public string $created_at;

    public function __construct(
        string $uri,
        string $role,
        object $user,
        string $organization,
        string $updated_at,
        string $created_at,
    ) {
        $this->uri = $uri;
        $this->role = $role;
        $this->user = $user;
        $this->organization = $organization;
        $this->updated_at = $updated_at;
        $this->created_at = $created_at;
    }
}
