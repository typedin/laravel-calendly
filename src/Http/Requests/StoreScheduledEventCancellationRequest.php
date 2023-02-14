<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class StoreScheduledEventCancellationRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required|string',
            'reason' => 'string',
        ];
    }
}
