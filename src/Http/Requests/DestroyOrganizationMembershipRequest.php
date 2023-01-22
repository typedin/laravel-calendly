<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyOrganizationMembershipRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
