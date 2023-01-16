<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\IndexActivityLogEntryRequest;

class CalendlyActivityLogEntriesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexActivityLogEntryRequest $request): JsonResponse
    {
        $response = $this->api->get("/activity_log_entries/", $request);

        $all = collect($response["collection"])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyActivityLogEntry::class)->all();
        return response()->json([
        "activity_log_entries" => $all,
        ]);
    }
}
