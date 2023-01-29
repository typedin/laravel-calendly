<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowScheduledEventInviteeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'event_uuid' => 'required|string',
            'invitee_uuid' => 'required|string',
        ];
    }
}
