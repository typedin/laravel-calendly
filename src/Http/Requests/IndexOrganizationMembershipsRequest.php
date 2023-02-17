<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexOrganizationMembershipsRequest extends \Illuminate\Foundation\Http\FormRequest
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
