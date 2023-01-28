<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexUserBusyTimesRequest extends Illuminate\Foundation\Http\FormRequest
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
