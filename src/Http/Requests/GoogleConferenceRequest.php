<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class GoogleConferenceRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:google_conference',
        'status' => 'required,in:initiated,processing,pushed,failed',
        'join_url' => 'nullable,url',
        ];
    }
}
