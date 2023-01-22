<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowOrganizationMembershipRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
