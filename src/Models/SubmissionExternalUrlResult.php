<?php

namespace Typedin\LaravelCalendly\Models;

class SubmissionExternalUrlResult
{
    /**
     * Indicates that the routing form submission resulted in a redirect to an external URL.
     */
    public string $type;

    /**
     * The external URL the respondent were redirected to.
     */
    public string $value;

    public function __construct(string $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }
}
