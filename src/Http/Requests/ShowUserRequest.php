<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowUserRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
