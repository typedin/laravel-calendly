<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ActorRequest
{
    public function rules(): array
    {
        return [
            'uri' => 'string',
            'type' => 'required,string',
            'organization' => 'object',
            'group' => 'object',
            'display_name' => 'string',
            'alternative_identifier' => 'string',
        ];
    }
}
