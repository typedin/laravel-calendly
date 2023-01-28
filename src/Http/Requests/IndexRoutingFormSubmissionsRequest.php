<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexRoutingFormSubmissionsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'form' => 'required,url',
            'sort' => 'string',
        ];
    }
}
