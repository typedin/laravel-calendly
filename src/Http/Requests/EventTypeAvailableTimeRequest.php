<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class EventTypeAvailableTimeRequest
{
    public function rules(): array
    {
        return [
        'status' => 'required,string',
        'invitees_remaining' => 'required,numeric',
        'start_time' => 'required,date',
        'scheduling_url' => 'required,url',
        ];
    }
}
