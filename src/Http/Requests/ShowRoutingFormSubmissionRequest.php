<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowRoutingFormSubmissionRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
