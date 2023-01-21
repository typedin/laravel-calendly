<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowEventTypeRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
