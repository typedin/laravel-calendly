<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyOrganization
{
    /**
     * Canonical resource reference
     */
    public string $uri;

    /**
     * Active subscription plan or trial plan
     * @var string<basic|essentials|professional|teams|enterprise> $plan
     */
    public string $plan;

    /**
     * Current stage of organization
     * @var string<trial|free|paid> $stage
     */
    public string $stage;

    /**
     * Timestamp of when the organization was created.
     */
    public string $created_at;

    /**
     * Timestamp of when the organization was created or updated.
     */
    public string $updated_at;

    public function __construct(string $uri, string $plan, string $stage, string $created_at, string $updated_at)
    {
        $this->uri = $uri;
        $this->plan = $plan;
        $this->stage = $stage;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
