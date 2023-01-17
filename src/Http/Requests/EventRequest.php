<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class EventRequest
{
    public function rules(): array
    {
        return [
            'uri' => 'required,url',
            'name' => 'nullable,string',
            'status' => 'required,in:active,canceled',
            'start_time' => 'required,date',
            'end_time' => 'required,date',
            'event_type' => 'required,url',
            'location' => 'required',
            'invitees_counter' => 'required,object',
            'created_at' => 'required,date',
            'updated_at' => 'required,date',
            'event_memberships' => 'required,array',
            'event_guests' => 'required,array',
            'cancellation' => '',
            'calendar_event' => 'required',
            'event_memberships.*.user' => 'required,url',
        ];
    }
}
