<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexUserAvailabilitySchedulesRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
