<?php

namespace Typedin\LaravelCalendly\Entities\CalendlyEventTypeCustomQuestion;

class CalendlyEventTypeCustomQuestion
{
    /**
     * The custom question that the host created for the event type.
     *
     * @var string
     */
    public string $name;

    /**
     * The type of response that the invitee provides to the custom question; can be one or multiple lines of text, a phone number, or single- or multiple-select.
     *
     * @var string<string|text|phone_number|single_select|multi_select>
     */
    public string $type;

    /**
     * The numerical position of the question on the event booking page after the name and email address fields.
     *
     * @var number
     */
    public \number $position;

    /**
     * true if the question created by the host is turned ON and visible on the event booking page; false if turned OFF and invisible on the event booking page.
     *
     * @var bool
     */
    public bool $enabled;

    /**
     * true if a response to the question created by the host is required for invitees to book the event type; false if not required.
     *
     * @var bool
     */
    public bool $required;

    /**
     * The invitee’s option(s) for single_select or multi_select type of responses.
     *
     * @var array
     */
    public array $answer_choices;

    /**
     * true if the custom question lets invitees record a written response in addition to single-select or multiple-select type of responses; false if it doesn’t.
     *
     * @var bool
     */
    public bool $include_other;

    public function __construct(
        string $name,
        string $type,
        \number $position,
        bool $enabled,
        bool $required,
        array $answer_choices,
        bool $include_other,
    ) {
        $this->name = $name;
        $this->type = $type;
        $this->position = $position;
        $this->enabled = $enabled;
        $this->required = $required;
        $this->answer_choices = $answer_choices;
        $this->include_other = $include_other;
    }
}
