<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInviteeNoShowRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invitee' => 'url',
        ];
    }
}
