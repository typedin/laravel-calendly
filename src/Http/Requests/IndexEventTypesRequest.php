<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexEventTypesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'active' => 'boolean',
            'organization' => 'url',
            'user' => 'url',
            'sort' => 'string',
        ];
    }
}
