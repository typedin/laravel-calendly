<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class ShowWebhookSubscriptionRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'webhook_uuid' => 'required,string',
        ];
    }
}
