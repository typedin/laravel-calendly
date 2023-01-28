<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexWebhookSubscriptionsRequest extends FormRequest
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
