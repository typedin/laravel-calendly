<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexRoutingFormsRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'organization' => 'required|url',
            'sort' => 'string',
        ];
    }
}
