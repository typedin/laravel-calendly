<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
