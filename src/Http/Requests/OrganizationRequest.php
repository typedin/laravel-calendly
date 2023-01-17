<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class OrganizationRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'plan' => 'required,in:basic,essentials,professional,teams,enterprise',
        'stage' => 'required,in:trial,free,paid',
        'created_at' => 'required,date',
        'updated_at' => 'required,date',
        ];
    }
}
