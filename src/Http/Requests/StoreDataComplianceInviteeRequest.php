<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class StoreDataComplianceInviteeRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'emails' => 'required,array',
        ];
    }
}
