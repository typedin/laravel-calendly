<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowEventTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
