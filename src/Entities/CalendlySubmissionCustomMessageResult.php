<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlySubmissionCustomMessageResult
{
    /**
     * Indicates if the routing form submission resulted in a custom "thank you" message.
     *
     * @var string<custom_message>
     */
    public string $type;

    /**
     * Contains an object with custom message headline and body.
     */
    public object $value;

    public function __construct(string $type, object $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}
