<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InviteeNoShowRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'invitee' => 'required,url',
        'created_at' => 'required,date',
        ];
    }
}
