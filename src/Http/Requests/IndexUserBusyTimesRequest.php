<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexUserBusyTimesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user' => 'required,url',
            'start_time' => 'required,date',
            'end_time' => 'required,date',
        ];
    }
}
