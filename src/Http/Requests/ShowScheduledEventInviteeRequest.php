<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowScheduledEventInviteeRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'event_uuid' => 'required,string',
            'invitee_uuid' => 'required,string',
        ];
    }
}
