<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class SubmissionEventTypeResultRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:event_type',
        'value' => 'required,url',
        ];
    }
}
