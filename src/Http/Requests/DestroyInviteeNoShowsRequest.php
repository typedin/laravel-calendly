<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyInviteeNoShowsRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
