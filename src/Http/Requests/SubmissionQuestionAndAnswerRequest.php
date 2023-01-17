<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class SubmissionQuestionAndAnswerRequest
{
    public function rules(): array
    {
        return [
        'question_uuid' => 'nullable,uuid',
        'question' => 'required,string',
        'answer' => 'string',
        ];
    }
}
