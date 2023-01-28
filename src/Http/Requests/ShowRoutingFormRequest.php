<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowRoutingFormRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
