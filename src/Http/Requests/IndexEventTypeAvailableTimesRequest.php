<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
