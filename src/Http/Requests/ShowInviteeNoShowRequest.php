<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowInviteeNoShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
