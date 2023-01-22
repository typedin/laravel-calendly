<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyOrganizationMembershipsRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,string',
        ];
    }
}
