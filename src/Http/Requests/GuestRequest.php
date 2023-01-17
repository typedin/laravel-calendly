<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class GuestRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required,email',
            'created_at' => 'required,date',
            'updated_at' => 'required,date',
        ];
    }
}
