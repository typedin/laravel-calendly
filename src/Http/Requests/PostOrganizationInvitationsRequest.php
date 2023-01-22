<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class PostOrganizationInvitationsRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
