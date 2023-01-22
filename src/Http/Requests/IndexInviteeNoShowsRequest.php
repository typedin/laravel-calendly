<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexInviteeNoShowsRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
