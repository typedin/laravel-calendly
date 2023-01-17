<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class MicrosoftTeamsConferenceRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:microsoft_teams_conference',
        'status' => 'required,in:initiated,processing,pushed,failed',
        'join_url' => 'nullable,url',
        'data' => 'nullable,object',
        ];
    }
}
