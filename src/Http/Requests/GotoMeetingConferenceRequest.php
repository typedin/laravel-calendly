<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class GotoMeetingConferenceRequest
{
    public function rules(): array
    {
        return [
        'type' => 'required,in:gotomeeting',
        'status' => 'required,in:initiated,processing,pushed,failed',
        'join_url' => 'nullable,url',
        'data' => 'nullable,object',
        ];
    }
}
