<?php

namespace Typedin\LaravelCalendly\Models;

class GotoMeetingConference
{
    /**
     * The event location is a GoToMeeting conference
     */
    public string $type;

    /**
     * Indicates the current status of the GoToMeeting conference
     */
    public string $status;

    /**
     * GoToMeeting conference meeting url
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
