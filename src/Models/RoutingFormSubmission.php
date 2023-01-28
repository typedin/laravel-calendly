<?php

namespace Typedin\LaravelCalendly\Models;

use SubmissionResult;
use SubmissionTracking;

class RoutingFormSubmission
{
    /**
     * Canonical reference (unique identifier) for the routing form submission.
     * @var string $uri
     */
    public string $uri;

    /**
     * The URI of the routing form that's associated with the submission.
     * @var string $routing_form
     */
    public string $routing_form;

    /**
     * All Routing Form Submission questions with answers.
     * @var array $questions_and_answers
     */
    public array $questions_and_answers;

    /**
     * The UTM and Salesforce tracking parameters associated with a Routing Form Submission.
     * @var  $tracking
     */
    public SubmissionTracking $tracking;

    /**
     * The polymorphic base type for a Routing Form Submission result.
     * @var Typedin\LaravelCalendly\Models\Result $result
     */
    public ?SubmissionResult $result;

    /**
     * The reference to the Invitee resource when routing form submission results in a scheduled meeting.
     * @var string $submitter
     */
    public ?string $submitter;

    /**
     * Type of the respondent resource that submitted the form and scheduled a meeting.
     * @var string<Invitee> $submitter_type
     */
    public ?string $submitter_type;

    /**
     * The moment the routing form was submitted.
     * @var string $created_at
     */
    public string $created_at;

    /**
     * The moment when the routing form submission was last updated.
     * @var string $updated_at
     */
    public string $updated_at;

    public function __construct(
        string $uri,
        string $routing_form,
        array $questions_and_answers,
        SubmissionTracking $tracking,
        ?SubmissionResult $result,
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
