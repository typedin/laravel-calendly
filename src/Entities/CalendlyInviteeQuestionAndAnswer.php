<?php

namespace Typedin\LaravelCalendly\Entities;

use number;

class CalendlyInviteeQuestionAndAnswer
{
    /**
     * A question on the invitee's booking form
     */
    public string $question;

    /**
     * The invitee's answer to the question
     */
    public string $answer;

    /**
     * The position of the question in relation to others on the booking form
     */
    public number $position;

    public function __construct(string $question, string $answer, number $position)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->position = $position;
    }
}
