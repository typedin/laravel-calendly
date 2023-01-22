<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowEventTypeRequest;

class CalendlyEventTypesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypesRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_types/', $request);

        $all = collect($response['collection'])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyEventType::class)->all();

        return response()->json([
            'event_types' => $all,
        ]);
    }

    public function show(ShowEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_types/{$uuid}/", $request);

        return response()->json([
            'event_type' => new \Typedin\LaravelCalendly\Entities\CalendlyEventType($response),
        ]);
    }
}
