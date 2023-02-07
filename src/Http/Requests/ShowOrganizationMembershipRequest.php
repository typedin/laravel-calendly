<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowOrganizationMembershipRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|string',
        ];
    }
}
