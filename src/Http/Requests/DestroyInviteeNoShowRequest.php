<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyInviteeNoShowRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
