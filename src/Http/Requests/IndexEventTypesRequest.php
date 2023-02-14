<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexEventTypesRequest extends \Illuminate\Foundation\Http\FormRequest
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
