<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class UserBusyTimeRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:calendly,external',
            'start_time' => 'required,date',
            'end_time' => 'required,date',
            'buffered_start_time' => 'date',
            'buffered_end_time' => 'date',
            'event' => 'object',
        ];
    }
}
