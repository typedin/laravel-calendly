<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowUserAvailabilityScheduleRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
