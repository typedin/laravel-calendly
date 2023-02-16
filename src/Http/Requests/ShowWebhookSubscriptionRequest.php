<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowWebhookSubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
        'webhook_uuid' => 'required|string',
        ];
    }
}
