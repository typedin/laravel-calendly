<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class IndexWebhookSubscriptionsRequest extends Illuminate\Foundation\Http\FormRequest
{
    public function rules(): array
    {
        return [
            'organization' => 'required,url',
            'user' => 'url',
            'sort' => 'string',
            'scope' => 'required,in:organization,user',
        ];
    }
}
