<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowUserAvailabilityScheduleRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
