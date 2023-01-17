<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class PaginationRequest
{
    public function rules(): array
    {
        return [
            'count' => 'required,numeric',
            'next_page' => 'nullable,url',
            'previous_page' => 'nullable,url',
            'next_page_token' => 'nullable,string',
            'previous_page_token' => 'nullable,string',
        ];
    }
}
