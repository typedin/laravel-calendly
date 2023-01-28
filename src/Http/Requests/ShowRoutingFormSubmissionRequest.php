<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowRoutingFormSubmissionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
