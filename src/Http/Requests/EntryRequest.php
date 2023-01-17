<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class EntryRequest
{
    public function rules(): array
    {
        return [
        'occurred_at' => 'required,date',
        'actor' => '',
        'details' => 'required,object',
        'fully_qualified_name' => 'required,regex:^[A-Za-z0-9\-_]+\.[A-Za-z0-9\-_]+$',
        'uri' => 'required,string',
        'namespace' => 'required,regex:^[A-Za-z0-9\-_]+$',
        'action' => 'required,regex:^[A-Za-z0-9\-_]+$',
        'organization' => 'required,string',
        ];
    }
}
