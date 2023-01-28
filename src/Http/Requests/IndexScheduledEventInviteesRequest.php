<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexScheduledEventInviteesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
            'status' => 'in:active,canceled',
            'sort' => 'string',
            'email' => 'email',
        ];
    }
}
