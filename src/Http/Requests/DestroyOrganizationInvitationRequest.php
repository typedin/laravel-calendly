<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyOrganizationInvitationRequest
{
    public function rules(): array
    {
        return [
            'org_uuid' => 'required,string',
            'uuid' => 'required,string',
        ];
    }
}
