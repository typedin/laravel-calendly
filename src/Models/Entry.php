<?php

namespace Typedin\LaravelCalendly\Models;

class Entry
{
    /**
     * The date and time of the entry (format: "2020-01-02T03:04:05.678Z").
     *
     * @var string
     */
    public string $occurred_at;

    /** @var  */
    public $actor;

    /** @var object */
    public object $details;

    /** @var string */
    public string $fully_qualified_name;

    /** @var string */
    public string $uri;

    /** @var string */
    public string $namespace;

    /** @var string */
    public string $action;

    /** @var string */
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
