<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexScheduledEventInviteesRequest
{
    public function rules(): array
    {
        return [
        'event_uuid' => 'required,string',
        'invitee_uuid' => 'required,string',
        ];
    }
}
