<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowScheduledEventInviteeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event_uuid' => 'required,string',
            'invitee_uuid' => 'required,string',
        ];
    }
}
