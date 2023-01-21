<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class PostOrganizationInvitationRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
