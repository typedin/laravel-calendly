<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class PostScheduledEventCancellationRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
