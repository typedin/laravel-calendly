<?php

namespace Typedin\LaravelCalendly\Models;

class EventTypeCustomQuestion
{
    /**
     * The custom question that the host created for the event type.
     */
    public string $name;

    /**
     * The type of response that the invitee provides to the custom question; can be one or multiple lines of text, a phone number, or single- or multiple-select.
     */
    public string $type;

    /**
     * The numerical position of the question on the event booking page after the name and email address fields.
     *
     * @var number
     */
    public float $position;

    /**
     * true if the question created by the host is turned ON and visible on the event booking page; false if turned OFF and invisible on the event booking page.
     */
    public bool $enabled;

    /**
     * true if a response to the question created by the host is required for invitees to book the event type; false if not required.
     */
    public bool $required;

    /**
     * The invitee’s option(s) for single_select or multi_select type of responses.
     */
    public array $answer_choices;

    /**
     * true if the custom question lets invitees record a written response in addition to single-select or multiple-select type of responses; false if it doesn’t.
     */
    public bool $include_other;

    public function __construct(
        string $name,
        string $type,
        float $position,
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
