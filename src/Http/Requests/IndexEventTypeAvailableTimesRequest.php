<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexEventTypeAvailableTimesRequest extends FormRequest
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
