<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ZoomConferenceRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:zoom_conference',
            'status' => 'required,in:initiated,processing,pushed,failed',
            'join_url' => 'nullable,url',
            'data' => 'nullable,object',
        ];
    }
}
