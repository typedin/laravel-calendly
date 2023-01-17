<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InviteeTrackingRequest
{
    public function rules(): array
    {
        return [
        'utm_campaign' => 'nullable,string',
        'utm_source' => 'nullable,string',
        'utm_medium' => 'nullable,string',
        'utm_content' => 'nullable,string',
        'utm_term' => 'nullable,string',
        'salesforce_uuid' => 'nullable,string',
        ];
    }
}
