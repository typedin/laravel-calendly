<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduledEventCancellationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
            'reason' => 'string',
        ];
    }
}
