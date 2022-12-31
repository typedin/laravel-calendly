<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyInviteeQuestionAndAnswer;

class CalendlyInviteeQuestionAndAnswer
{
    /**
     * The position of the question in relation to others on the booking form
     */
    public \number $position;

    public function __construct(/**
  * A question on the invitee's booking form
  */
 public string $question, /**
  * The invitee's answer to the question
  */
 public string $answer, \number $position)
    {
        $this->position = $position;
    }
}
