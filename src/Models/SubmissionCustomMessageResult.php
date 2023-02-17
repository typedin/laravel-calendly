<?php

namespace Typedin\LaravelCalendly\Models;

class SubmissionCustomMessageResult
{
    /**
     * Indicates if the routing form submission resulted in a custom "thank you" message.
     * @var string $type
     */
    public string $type;

    /**
     * Contains an object with custom message headline and body.
     * @var object $value
     */
    public object $value;

    public function __construct(string $type, object $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}
