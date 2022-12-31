<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyRoutingForm;

class CalendlyRoutingForm
{
    /**
     * Canonical reference (unique identifier) for the routing form.
     *
     * @var string
     */
    public string $uri;

    /**
     * The URI of the organization that's associated with the routing form.
     *
     * @var string
     */
    public string $organization;

    /**
     * The routing form name (in human-readable format).
     *
     * @var string
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
     *
     * @var array
     */
    public array $questions;

    /**
     * The moment the routing form was created.
     *
     * @var string
     */
    public string $created_at;

    /**
     * The moment when the routing form was last updated.
     *
     * @var string
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
