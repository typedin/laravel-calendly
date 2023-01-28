<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class StoreInviteeNoShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invitee' => 'url',
        ];
    }
}
