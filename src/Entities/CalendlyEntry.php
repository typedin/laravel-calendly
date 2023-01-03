<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyEntry;

class CalendlyEntry
{
    /** @var string $action */
    public string $action;

    /** @var object $details */
    public object $details;

    /** @var string $fully_qualified_name */
    public string $fully_qualified_name;

    /** @var string $uri */
    public string $uri;

    /** @var string $namespace */
    public string $namespace;

    /**
     * The date and time of the entry (format: "2020-01-02T03:04:05.678Z").
     * @var string $occurred_at
     */
    public string $occurred_at;

    /** @var string $organization */
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
