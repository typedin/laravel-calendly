<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
