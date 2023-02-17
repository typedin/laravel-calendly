<?php

namespace Typedin\LaravelCalendly\Models;

class Question
{
    /**
     * Unique identifier for the routing form question.
     * @var string $uuid
     */
    public string $uuid;

    /**
     * Question name (in human-readable format).
     * @var string $name
     */
    public string $name;

    /**
     * Question type: name, text input, email, phone, textarea input, dropdown list or radio button list.
     * @var string $type
     */
    public string $type;

    /**
     * true if an answer to the question is required for respondents to submit the routing form; false if not required.
     *
     * @var bool $required
     */
    public bool $required;

    /**
     * The respondent’s option(s) for "select" or "radios" types of questions.
     * @var array $answer_choices
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
