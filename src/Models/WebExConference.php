<?php

namespace Typedin\LaravelCalendly\Models;

class WebExConference
{
    /**
     * The event location is a WebEx conference
     */
    public string $type;

    /**
     * Indicates the current status of the WebEx conference
     */
    public string $status;

    /**
     * WebEx conference meeting url
     */
    public ?string $join_url;

    /**
     * The conference metadata supplied by GoToMeeting
     */
    public ?object $data;

    public function __construct(string $type, string $status, ?string $join_url, ?object $data)
    {
        $this->type = $type;
        $this->status = $status;
        $this->join_url = $join_url;
        $this->data = $data;
    }
}
