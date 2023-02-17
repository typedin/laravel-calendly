<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDataComplianceDeletionInviteeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'emails' => 'required|array',
        ];
    }
}
