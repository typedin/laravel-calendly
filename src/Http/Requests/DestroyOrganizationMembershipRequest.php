<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyOrganizationMembershipRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|string',
        ];
    }
}
