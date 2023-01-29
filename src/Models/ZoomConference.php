<?php

namespace Typedin\LaravelCalendly\Models;

class ZoomConference
{
    /**
     * The event location is a Zoom conference
     */
    public string $type;

    /**
     * Indicates the current status of the Zoom conference
     */
    public string $status;

    /**
     * Zoom meeting url
     */
    public ?string $join_url;

    /**
     * The conference metadata supplied by Zoom
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
