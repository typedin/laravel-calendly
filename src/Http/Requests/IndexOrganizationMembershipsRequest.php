<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexOrganizationMembershipsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'email',
            'organization' => 'url',
            'user' => 'url',
        ];
    }
}
