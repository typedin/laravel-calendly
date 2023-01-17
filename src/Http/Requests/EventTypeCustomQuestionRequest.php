<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class EventTypeCustomQuestionRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required,string',
            'type' => 'required,in:string,text,phone_number,single_select,multi_select',
            'position' => 'required,numeric',
            'enabled' => 'required,boolean',
            'required' => 'required,boolean',
            'answer_choices' => 'required,array',
            'include_other' => 'required,boolean',
        ];
    }
}
