<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class StoreOrganizationInvitationRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
