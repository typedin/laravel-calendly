<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowOrganizationInvitationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'org_uuid' => 'required,string',
            'uuid' => 'required,string',
        ];
    }
}
