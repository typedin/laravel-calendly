<?php

namespace Typedin\LaravelCalendly\Models;

class Actor
{
    /**
     * Canonical reference (unique identifier) for the user
     *
     * @var string
     */
    public ?string $uri;

    /**
     * The type of actor
     *
     * @var string
     */
    public string $type;

    /** @var object */
    public ?object $organization;

    /**
     * User group information about the actor
     *
     * @var object
     */
    public ?object $group;

    /**
     * The user's name (human-readable format)
     *
     * @var string
     */
    public ?string $display_name;

    /**
     * Username of the actor
     *
     * @var string
     */
    public ?string $alternative_identifier;

    public function __construct(
        ?string $uri,
        string $type,
        ?object $organization,
        ?object $group,
        ?string $display_name,
        ?string $alternative_identifier,
    ) {
        $this->uri = $uri;
        $this->type = $type;
        $this->organization = $organization;
        $this->group = $group;
        $this->display_name = $display_name;
        $this->alternative_identifier = $alternative_identifier;
    }
}
