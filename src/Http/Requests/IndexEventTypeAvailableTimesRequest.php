<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexEventTypeAvailableTimesRequest
{
    public function rules(): array
    {
        return [
        'event_type' => 'url',
        'start_time' => 'date',
        'end_time' => 'date',
        ];
    }
}
