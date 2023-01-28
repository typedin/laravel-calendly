<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class StoreSchedulingLinkRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'max_event_count' => 'required,in:1',
            'owner' => 'required,url',
            'owner_type' => 'required,in:EventType',
        ];
    }
}
