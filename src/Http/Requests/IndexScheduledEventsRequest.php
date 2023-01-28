<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexScheduledEventsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user' => 'url',
            'organization' => 'url',
            'invitee_email' => 'email',
            'status' => 'in:active,canceled',
            'sort' => 'string',
            'min_start_time' => 'date',
            'max_start_time' => 'date',
        ];
    }
}
