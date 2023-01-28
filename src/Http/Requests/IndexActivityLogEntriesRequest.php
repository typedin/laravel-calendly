<?php

namespace Typedin\LaravelCalendly\Http\Requests;

use FormRequest;

class IndexActivityLogEntriesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'organization' => 'required,url',
            'search_term' => 'string',
            'actor' => 'array',
            'sort' => 'array',
            'min_occurred_at' => 'date',
            'max_occurred_at' => 'date',
            'page_token' => 'string',
            'count' => 'integer',
            'namespace' => 'array',
            'action' => 'array',
        ];
    }
}
