<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyQuestion;

class CalendlyQuestion
{
    /**
     * @param mixed $type
     */
    public function __construct(
        /**
         * Unique identifier for the routing form question.
         */
        public string $uuid,
        /**
         * Question name (in human-readable format).
         */
        public string $name,
        /**
         * Question type: name, text input, email, phone, textarea input, dropdown list or radio button list.
         */
        public string $type,
        /**
         * true if an answer to the question is required for respondents to submit the routing form; false if not required.
         */
        public bool $required,
        /**
         * The respondent’s option(s) for "select" or "radios" types of questions.
         */
        public ?array $answer_choices
    )
    {
    }
}
