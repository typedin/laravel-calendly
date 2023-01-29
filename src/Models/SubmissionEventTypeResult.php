<?php

namespace Typedin\LaravelCalendly\Models;

class SubmissionEventTypeResult
{
    /**
     * Indicates that the routing form submission resulted in a redirect to an event type booking page.
     */
    public string $type;

    /**
     * A reference to the event type resource.
     */
    public string $value;

    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}
