<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowUserAvailabilityScheduleRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
