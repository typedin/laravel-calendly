<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class StoreWebhookSubscriptionRequest extends \Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'url' => 'required|url',
            'events' => 'required|array',
            'organization' => 'required|url',
            'user' => 'url',
            'scope' => 'required|in:organization,user',
            'signing_key' => 'string',
        ];
    }
}
