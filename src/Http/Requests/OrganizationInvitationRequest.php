<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class OrganizationInvitationRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'organization' => 'required,string',
        'email' => 'required,email',
        'status' => 'required,in:pending,accepted,declined',
        'created_at' => 'required,date',
        'updated_at' => 'required,date',
        'last_sent_at' => 'nullable,date',
        'user' => 'url',
        ];
    }
}
