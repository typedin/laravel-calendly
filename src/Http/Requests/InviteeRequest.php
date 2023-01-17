<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class InviteeRequest
{
    public function rules(): array
    {
        return [
        'uri' => 'required,url',
        'email' => 'required,email',
        'first_name' => 'nullable,string',
        'last_name' => 'nullable,string',
        'name' => 'required,string',
        'status' => 'required,in:active,canceled',
        'questions_and_answers' => 'required,array',
        'timezone' => 'nullable,string',
        'event' => 'required,url',
        'created_at' => 'required,date',
        'updated_at' => 'required,date',
        'tracking' => 'required',
        'text_reminder_number' => 'nullable,string',
        'rescheduled' => 'required,boolean',
        'old_invitee' => 'nullable,url',
        'new_invitee' => 'nullable,url',
        'cancel_url' => 'required,url',
        'reschedule_url' => 'required,url',
        'routing_form_submission' => 'nullable,url',
        'cancellation' => '',
        'payment' => 'nullable,object',
        'no_show' => 'nullable,object',
        'reconfirmation' => 'nullable,object',
        ];
    }
}
