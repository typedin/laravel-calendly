<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWebhookSubscriptionRequest extends FormRequest
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
