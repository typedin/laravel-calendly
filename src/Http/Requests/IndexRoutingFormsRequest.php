<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexRoutingFormsRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
