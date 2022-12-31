<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyRoutingFormSubmission;

class CalendlyRoutingFormSubmission
{
    /**
     * @param mixed $submitter_type
     */
    public function __construct(
        /**
         * Canonical reference (unique identifier) for the routing form submission.
         */
        public string $uri,
        /**
         * The URI of the routing form that's associated with the submission.
         */
        public string $routing_form,
        /**
         * All Routing Form Submission questions with answers.
         */
        public array $questions_and_answers,
        public $tracking,
        /**
         * The reference to the Invitee resource when routing form submission results in a scheduled meeting.
         */
        public ?string $submitter,
        /**
         * Type of the respondent resource that submitted the form and scheduled a meeting.
         */
        public ?string $submitter_type,
        /**
         * The moment the routing form was submitted.
         */
        public string $created_at,
        /**
         * The moment when the routing form submission was last updated.
         */
        public string $updated_at
    )
    {
    }
}
