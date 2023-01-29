<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexActivityLogEntriesRequest;
use Typedin\LaravelCalendly\Models\Entry;

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

        if ($response->ok()) {
            $all = collect($response->collect('collection'))
            ->mapInto(Entry::class)->all();

            return response()->json([
                'activity_log_entries' => $all,
            ]);
        }
    }
}
