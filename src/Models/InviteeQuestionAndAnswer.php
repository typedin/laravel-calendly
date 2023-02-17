<?php

namespace Typedin\LaravelCalendly\Models;

class InviteeQuestionAndAnswer
{
    /**
     * A question on the invitee's booking form
     * @var string $question
     */
    public string $question;

    /**
     * The invitee's answer to the question
     * @var string $answer
     */
    public string $answer;

    /**
     * The position of the question in relation to others on the booking form
     * @var float $position
     */
    public float $position;

    public function __construct(string $question, string $answer, float $position)
    {
        $this->question = $question;
        $this->answer = $answer;
        $this->position = $position;
    }
}
