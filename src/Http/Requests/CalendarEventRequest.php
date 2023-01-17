<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class CalendarEventRequest
{
    public function rules(): array
    {
        return [
        'kind' => 'required,in:exchange,google,icloud,outlook,outlook_desktop',
        'external_id' => 'required,string',
        ];
    }
}
