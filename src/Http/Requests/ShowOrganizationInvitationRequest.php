<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowOrganizationInvitationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'org_uuid' => 'required|string',
            'uuid' => 'required|string',
        ];
    }
}
