<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InviteeSpecifiedLocationRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:ask_invitee',
            'location' => 'required,string',
        ];
    }
}
