<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class ShowWebhookSubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'webhook_uuid' => 'required,string',
        ];
    }
}
