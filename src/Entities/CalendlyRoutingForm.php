<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyRoutingForm
{
    /**
     * Canonical reference (unique identifier) for the routing form.
     */
    public string $uri;

    /**
     * The URI of the organization that's associated with the routing form.
     */
    public string $organization;

    /**
     * The routing form name (in human-readable format).
     */
    public string $name;

    /**
     * Indicates if the form is in "draft" or "published" status.
     *
     * @var string<draft|published>
     */
    public string $status;

    /**
     * An ordered collection of Routing Form non-deleted questions.
     */
    public array $questions;

    /**
     * The moment the routing form was created.
     */
    public string $created_at;

    /**
     * The moment when the routing form was last updated.
     */
    public string $updated_at;

    public function __construct(
        string $uri,
        string $organization,
        string $name,
        string $status,
        array $questions,
        string $created_at,
        string $updated_at,
    ) {
        $this->uri = $uri;
        $this->organization = $organization;
        $this->name = $name;
        $this->status = $status;
        $this->questions = $questions;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
