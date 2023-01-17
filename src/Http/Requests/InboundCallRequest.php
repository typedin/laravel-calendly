<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InboundCallRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:inbound_call',
            'location' => 'required,string',
        ];
    }
}
