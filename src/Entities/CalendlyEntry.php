<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyEntry
{
    /** @var string */
    public string $action;

    /** @var object */
    public object $details;

    /** @var string */
    public string $fully_qualified_name;

    /** @var string */
    public string $uri;

    /** @var string */
    public string $namespace;

    /**
     * The date and time of the entry (format: "2020-01-02T03:04:05.678Z").
     *
     * @var string
     */
    public string $occurred_at;

    /** @var string */
    public string $organization;

    public function __construct(
        string $action,
        object $details,
        string $fully_qualified_name,
        string $uri,
        string $namespace,
        string $occurred_at,
        string $organization,
    ) {
        $this->action = $action;
        $this->details = $details;
        $this->fully_qualified_name = $fully_qualified_name;
        $this->uri = $uri;
        $this->namespace = $namespace;
        $this->occurred_at = $occurred_at;
        $this->organization = $organization;
    }
}
