<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class DestroyWebhookSubscriptionsRequest
{
    public function rules(): array
    {
        return [
            'webhook_uuid' => 'required,string',
        ];
    }
}
