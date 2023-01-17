<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class RoutingFormRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'organization' => 'required,url',
        'name' => 'required,string',
        'status' => 'required,in:draft,published',
        'questions' => 'required,array',
        'created_at' => 'required,date',
        'updated_at' => 'required,date',
        ];
    }
}
