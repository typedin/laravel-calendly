<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class OrganizationMembershipRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'role' => 'required,in:user,admin,owner',
        'user' => 'required,object',
        'organization' => 'required,url',
        'updated_at' => 'required,date',
        'created_at' => 'required,date',
        ];
    }
}
