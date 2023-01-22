<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class PostScheduledEventCancellationsRequest
{
    public function rules(): array
    {
        return [
            'uuid' => 'required,string',
        ];
    }
}
