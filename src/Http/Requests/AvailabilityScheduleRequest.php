<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class AvailabilityScheduleRequest
{
    public function rules(): array
    {
        return [
            'uri' => 'required,url',
            'default' => 'required,boolean',
            'name' => 'required,string',
            'user' => 'required,url',
            'timezone' => 'required,string',
            'rules' => 'required,array',
        ];
    }
}
