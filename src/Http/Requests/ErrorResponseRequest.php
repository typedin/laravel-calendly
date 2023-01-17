<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ErrorResponseRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required,string',
            'message' => 'required,string',
            'details' => 'array',
            'details.*.parameter' => 'string',
            'details.*.message' => 'required,string',
        ];
    }
}
