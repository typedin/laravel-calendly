<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class OutboundCallRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:outbound_call',
        'location' => 'nullable,string',
        ];
    }
}
