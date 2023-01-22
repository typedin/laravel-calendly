<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexWebhookSubscriptionsRequest
{
    public function rules(): array
    {
        return [
        'webhook_uuid' => 'required,string',
        ];
    }
}
