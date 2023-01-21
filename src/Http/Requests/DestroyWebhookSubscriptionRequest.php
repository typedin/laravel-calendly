<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyWebhookSubscriptionRequest
{
    public function rules(): array
    {
        return [
        'webhook_uuid' => 'required,string',
        ];
    }
}
