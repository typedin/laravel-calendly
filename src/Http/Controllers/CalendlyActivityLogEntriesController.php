<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyActivityLogEntry;
use Typedin\LaravelCalendly\Http\IndexActivityLogEntryRequest;

class CalendlyActivityLogEntriesController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function index(IndexActivityLogEntryRequest $request): JsonResponse
    {
        $response = $this->api->get('/activity_log_entries/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyActivityLogEntry::class)->all();

        return response()->json([
            'activity_log_entries' => $all,
        ]);
    }
}
