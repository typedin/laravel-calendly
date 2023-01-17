<?php

namespace Typedin\LaravelCalendly\Http\Requests;

class AvailabilityRuleRequest
{
    public function rules(): array
    {
        return [
            'type' => 'required,in:wday,date',
            'intervals' => 'required,array',
            'wday' => 'in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'date' => 'regex:^\d{4}\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01])$',
            'intervals.*.from' => 'regex:(\d\d):(\d\d)',
            'intervals.*.to' => 'regex:(\d\d):(\d\d)',
        ];
    }
}
