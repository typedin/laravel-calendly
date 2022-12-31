<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyEventTypeCustomQuestion;

class CalendlyEventTypeCustomQuestion
{
    /**
     * The numerical position of the question on the event booking page after the name and email address fields.
     */
    public \number $position;

    /**
     * @param mixed $type
     */
    public function __construct(
        /**
         * The custom question that the host created for the event type.
         */
        public string $name,
        /**
         * The type of response that the invitee provides to the custom question; can be one or multiple lines of text, a phone number, or single- or multiple-select.
         */
        public string $type,
        \number $position,
        /**
         * true if the question created by the host is turned ON and visible on the event booking page; false if turned OFF and invisible on the event booking page.
         */
        public bool $enabled,
        /**
         * true if a response to the question created by the host is required for invitees to book the event type; false if not required.
         */
        public bool $required,
        /**
         * The invitee’s option(s) for single_select or multi_select type of responses.
         */
        public array $answer_choices,
        /**
         * true if the custom question lets invitees record a written response in addition to single-select or multiple-select type of responses; false if it doesn’t.
         */
        public bool $include_other,
    ) {
        $this->position = $position;
    }
}
