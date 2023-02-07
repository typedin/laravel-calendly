<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexEventTypeAvailableTimesRequest extends \Illuminate\Foundation\Http\FormRequest
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
