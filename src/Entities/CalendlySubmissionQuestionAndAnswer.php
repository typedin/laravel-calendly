<?php

namespace Typedin\LaravelCalendly\Entities\CalendlySubmissionQuestionAndAnswer;

class CalendlySubmissionQuestionAndAnswer
{
    public function __construct(
     /**
      * Unique identifier for the routing form question.
      */
     public ?string $question_uuid,
     /**
      * Question name (in human-readable format).
      */
     public string $question
 ) {
    }
}
