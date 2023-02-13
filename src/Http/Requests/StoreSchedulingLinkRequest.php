<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class StoreSchedulingLinkRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'max_event_count' => 'required|in:1',
            'owner' => 'required|url',
            'owner_type' => 'required|in:EventType',
        ];
    }
}
