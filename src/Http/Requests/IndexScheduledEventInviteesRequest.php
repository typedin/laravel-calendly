<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexScheduledEventInviteesRequest extends Illuminate\Foundation\Http\FormRequest
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
