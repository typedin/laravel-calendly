<?php

namespace Typedin\LaravelCalendly\Models;

class Question
{
    /**
     * Unique identifier for the routing form question.
     */
    public string $uuid;

    /**
     * Question name (in human-readable format).
     */
    public string $name;

    /**
     * Question type: name, text input, email, phone, textarea input, dropdown list or radio button list.
     */
    public string $type;

    /**
     * true if an answer to the question is required for respondents to submit the routing form; false if not required.
     */
    public bool $required;

    /**
     * The respondent’s option(s) for "select" or "radios" types of questions.
     *
     * @var array
     */
    public ?array $answer_choices;

    public function __construct(string $uuid, string $name, string $type, bool $required, ?array $answer_choices)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->type = $type;
        $this->required = $required;
        $this->answer_choices = $answer_choices;
    }
}
