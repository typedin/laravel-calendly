<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowOrganizationInvitationRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'org_uuid' => 'required,string',
            'uuid' => 'required,string',
        ];
    }
}
