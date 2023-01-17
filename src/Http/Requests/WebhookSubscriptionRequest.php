<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class WebhookSubscriptionRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'callback_url' => 'required,url',
        'created_at' => 'required,date',
        'updated_at' => 'required,date',
        'retry_started_at' => 'nullable,date',
        'state' => 'required,in:active,disabled',
        'events' => 'required,array',
        'scope' => 'required,in:user,organization',
        'organization' => 'required,url',
        'user' => 'nullable,url',
        'creator' => 'nullable,url',
        ];
    }
}
