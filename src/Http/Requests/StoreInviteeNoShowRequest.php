<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class StoreInviteeNoShowRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'invitee' => 'url',
        ];
    }
}
