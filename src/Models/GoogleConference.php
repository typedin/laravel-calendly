<?php

namespace Typedin\LaravelCalendly\Models;

class GoogleConference
{
    /**
     * The event location is a Google Meet or Hangouts conference
     */
    public string $type;

    /**
     * Indicates the current status of the Google conference
     */
    public string $status;

    /**
     * Google conference meeting url
     */
    public ?string $join_url;

    public function __construct(string $type, string $status, ?string $join_url)
    {
        $this->type = $type;
        $this->status = $status;
        $this->join_url = $join_url;
    }
}
