<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class WebhookPayloadRequest
{
    public function rules(): array
    {
        return [
        'event' => 'required,in:invitee.created,invitee.canceled,routing_form_submission.created',
        'created_at' => 'required,date',
        'created_by' => 'required,url',
        'payload' => 'required',
        ];
    }
}
