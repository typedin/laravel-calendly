<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class SubmissionExternalUrlResultRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:external_url',
        'value' => 'required,url',
        ];
    }
}
