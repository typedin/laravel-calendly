<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InPersonMeetingRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:physical',
            'location' => 'required,string',
        ];
    }
}
