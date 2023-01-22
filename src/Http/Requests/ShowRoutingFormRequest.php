<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowRoutingFormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
