<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class QuestionRequest
{
    public function rules(): array
    {
        return [
        'uuid' => 'required,uuid',
        'name' => 'required,string',
        'type' => 'required,in:name,text,email,phone,textarea,select,radios',
        'required' => 'required,boolean',
        'answer_choices' => 'nullable,array',
        ];
    }
}
