<?php

namespace Typedin\LaravelCalendly\Entities;

class CalendlyMicrosoftTeamsConference
{
    /**
     * The event location is a Zoom conference
     * @var string<microsoft_teams_conference>
     */
    public string $type;

    /**
     * Indicates the current status of the Microsoft Teams conference
     * @var string<initiated|processing|pushed|failed>
     */
    public string $status;

    /**
     * Microsoft Teams meeting url
     * @var string|null
     */
    public string $join_url;

    /**
     * The conference metadata supplied by Microsoft Teams
     * @var object|null
     */
    public object $data;

    public function __construct(string $type, string $status, ?string $join_url, ?object $data)
    {
        $this->type = $type;
        $this->status = $status;
        $this->join_url = $join_url;
        $this->data = $data;
    }
}
