<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class CancellationRequest
{
    public function rules(): array
    {
        return [
            'canceled_by' => 'required,string',
            'reason' => 'nullable,string',
            'canceler_type' => 'required,in:host,invitee',
        ];
    }
}
