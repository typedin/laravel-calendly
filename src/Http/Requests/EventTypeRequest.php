<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class EventTypeRequest
{
    public function rules(): array
    {
        return [
            'uri' => 'required,url',
            'name' => 'nullable,string',
            'active' => 'required,boolean',
            'slug' => 'nullable,string',
            'scheduling_url' => 'required,url',
            'duration' => 'required,numeric',
            'kind' => 'required,in:solo,group',
            'pooling_type' => 'nullable,in:round_robin,collective',
            'type' => 'required,in:StandardEventType,AdhocEventType',
            'color' => 'required,regex:^#[a-f\d]{6}$',
            'created_at' => 'required,date',
            'updated_at' => 'required,date',
            'internal_note' => 'nullable,string',
            'description_plain' => 'nullable,string',
            'description_html' => 'nullable,string',
            'profile' => 'required',
            'secret' => 'required,boolean',
            'booking_method' => 'required,in:instant,poll',
            'custom_questions' => 'required,array',
            'deleted_at' => 'nullable,date',
            'kind_description' => 'required,in:Collective,Group,One-on-One,Round Robin',
            'admin_managed' => 'required,boolean',
        ];
    }
}
