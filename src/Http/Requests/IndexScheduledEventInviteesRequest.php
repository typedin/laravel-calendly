<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexScheduledEventInviteesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required|string',
        'status' => 'in:active,canceled',
        'sort' => 'string',
        'email' => 'email',
        ];
    }
}
