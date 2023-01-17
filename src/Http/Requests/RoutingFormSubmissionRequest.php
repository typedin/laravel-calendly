<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class RoutingFormSubmissionRequest
{
    public function rules(): array
    {
        return [
            'uri' => 'required,url',
            'routing_form' => 'required,url',
            'questions_and_answers' => 'required,array',
            'tracking' => 'required',
            'result' => '',
            'submitter' => 'nullable,url',
            'submitter_type' => 'nullable,in:Invitee',
            'created_at' => 'required,date',
            'updated_at' => 'required,date',
        ];
    }
}
