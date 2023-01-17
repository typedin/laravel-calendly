<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InviteeQuestionAndAnswerRequest
{
    public function rules(): array
    {
        return [
        'question' => 'required,string',
        'answer' => 'required,string',
        'position' => 'required,numeric',
        ];
    }
}
