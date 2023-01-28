<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexRoutingFormsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'organization' => 'required,url',
            'sort' => 'string',
        ];
    }
}
