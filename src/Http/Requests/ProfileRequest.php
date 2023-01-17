<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ProfileRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:User,Team',
        'name' => 'required,string',
        'owner' => 'required,url',
        ];
    }
}
