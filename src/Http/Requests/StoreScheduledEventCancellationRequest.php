<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

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
