<?php

namespace Typedin\LaravelCalendly\Models;

class Entry
{
    /**
     * The date and time of the entry (format: "2020-01-02T03:04:05.678Z").
     * @var string $occurred_at
     */
    public string $occurred_at;
    public $actor;

    /** @var object $details */
    public object $details;

    /** @var string $fully_qualified_name */
    public string $fully_qualified_name;

    /** @var string $uri */
    public string $uri;

    /** @var string $namespace */
    public string $namespace;

    /** @var string $action */
    public string $action;

    /** @var string $organization */
    public string $organization;

    public function __construct(
        string $occurred_at,
        $actor,
        object $details,
        string $fully_qualified_name,
        string $uri,
        string $namespace,
        string $action,
        string $organization,
    ) {
        $this->occurred_at = $occurred_at;
        $this->actor = $actor;
        $this->details = $details;
        $this->fully_qualified_name = $fully_qualified_name;
        $this->uri = $uri;
        $this->namespace = $namespace;
        $this->action = $action;
        $this->organization = $organization;
    }
}
