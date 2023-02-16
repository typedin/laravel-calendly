<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DestroyWebhookSubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
        'webhook_uuid' => 'required|string',
        ];
    }
}
