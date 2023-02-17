<?php

namespace Typedin\LaravelCalendly\Models;

class RoutingFormSubmission
{
    /**
     * Canonical reference (unique identifier) for the routing form submission.
     */
    public string $uri;

    /**
     * The URI of the routing form that's associated with the submission.
     */
    public string $routing_form;

    /**
     * All Routing Form Submission questions with answers.
     */
    public array $questions_and_answers;

    public $tracking;

    public $result;

    /**
     * The reference to the Invitee resource when routing form submission results in a scheduled meeting.
     *
     * @var string
     */
    public ?string $submitter;

    /**
     * Type of the respondent resource that submitted the form and scheduled a meeting.
     *
     * @var string
     */
    public ?string $submitter_type;

    /**
     * The moment the routing form was submitted.
     */
    public string $created_at;

    /**
     * The moment when the routing form submission was last updated.
     */
    public string $updated_at;

    public function __construct(
        string $uri,
        string $routing_form,
        array $questions_and_answers,
        $tracking,
        $result,
        ?string $submitter,
        ?string $submitter_type,
        string $created_at,
        string $updated_at,
    ) {
        $this->uri = $uri;
        $this->routing_form = $routing_form;
        $this->questions_and_answers = $questions_and_answers;
        $this->tracking = $tracking;
        $this->result = $result;
        $this->submitter = $submitter;
        $this->submitter_type = $submitter_type;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}
