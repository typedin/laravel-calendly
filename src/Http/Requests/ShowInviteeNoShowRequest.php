<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowInviteeNoShowRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
