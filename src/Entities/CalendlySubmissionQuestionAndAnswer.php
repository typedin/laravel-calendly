<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlySubmissionQuestionAndAnswer
{
    /**
     * Unique identifier for the routing form question.
     * @var string|null $question_uuid
     */
    public string $question_uuid;

    /**
     * Question name (in human-readable format).
     * @var string $question
     */
    public string $question;

    public function __construct(?string $question_uuid, string $question)
    {
        $this->question_uuid = $question_uuid;
        $this->question = $question;
    }
}
