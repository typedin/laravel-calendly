<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class CustomLocationRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:custom',
            'location' => 'nullable,string',
        ];
    }
}
