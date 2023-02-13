<?php

namespace Typedin\LaravelCalendly\Models;

class SubmissionQuestionAndAnswer
{
    /**
     * Unique identifier for the routing form question.
     *
     * @var string
     */
    public ?string $question_uuid;

    /**
     * Question name (in human-readable format).
     *
     * @var string
     */
    public string $question;

    /**
     * Answer provided by the respondent when the form was submitted.
     *
     * @var string
     */
    public ?string $answer;

    public function __construct(?string $question_uuid, string $question, ?string $answer)
    {
        $this->question_uuid = $question_uuid;
        $this->question = $question;
        $this->answer = $answer;
    }
}
