<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class WebExConferenceRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:webex_conference',
        'status' => 'required,in:initiated,processing,pushed,failed',
        'join_url' => 'nullable,url',
        'data' => 'nullable,object',
        ];
    }
}
