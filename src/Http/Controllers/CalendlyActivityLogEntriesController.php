<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyActivityLogEntriesController;

class CalendlyActivityLogEntriesController extends Illuminate\Routing\Controller
{
    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(\Typedin\LaravelCalendly\Http\IndexActivityLogEntryRequest $request)
    {
        $response = $this->api->get('/activity_log_entries/', $request);

        $all = collect($response['collection'])
        ->mapInto(ActivityLogEntry::class)->all();

        return response()->json([
            'activity_log_entries' => $all,
        ]);
    }
}
