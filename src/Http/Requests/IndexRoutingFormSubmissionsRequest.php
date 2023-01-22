<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexRoutingFormSubmissionsRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
