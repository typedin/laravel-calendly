<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowWebhookSubscriptionRequest
{
    public function rules(): array
    {
        return [
            'webhook_uuid' => 'required,string',
        ];
    }
}
