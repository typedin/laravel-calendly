<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexRoutingFormSubmissionsRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'form' => 'required|url',
            'sort' => 'string',
        ];
    }
}
