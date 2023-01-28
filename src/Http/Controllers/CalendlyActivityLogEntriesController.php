<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexActivityLogEntriesRequest;
use JsonResponse;
use Typedin\LaravelCalendly\Entities\CalendlyActivityLogEntry;

class CalendlyActivityLogEntriesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexActivityLogEntriesRequest $request): JsonResponse
    {
        $response = $this->api->get('/activity_log_entries/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyActivityLogEntry::class)->all();

        return response()->json([
            'activity_log_entries' => $all,
        ]);
    }
}
