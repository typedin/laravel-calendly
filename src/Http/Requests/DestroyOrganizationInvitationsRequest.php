<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyOrganizationInvitationsRequest
{
    public function rules(): array
    {
        return [
            'org_uuid' => 'required,string',
            'uuid' => 'required,string',
        ];
    }
}
