<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class SubmissionCustomMessageResultRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:custom_message',
        'value' => 'required,object',
        ];
    }
}
