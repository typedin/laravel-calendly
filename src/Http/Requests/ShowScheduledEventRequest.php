<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowScheduledEventRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
