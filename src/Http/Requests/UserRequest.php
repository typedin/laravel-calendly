<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class UserRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'name' => 'required,string',
        'slug' => 'required,string',
        'email' => 'required,email',
        'scheduling_url' => 'required,url',
        'timezone' => 'required,string',
        'avatar_url' => 'nullable,url',
        'created_at' => 'required,date',
        'updated_at' => 'required,date',
        'current_organization' => 'required,url',
        ];
    }
}
