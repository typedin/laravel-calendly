<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyEventType;
use Typedin\LaravelCalendly\Http\GetEventTypeRequest;
use Typedin\LaravelCalendly\Http\IndexEventTypeRequest;

class CalendlyEventTypesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_types/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyEventType::class)->all();

        return response()->json([
            'event_types' => $all,
        ]);
    }

    public function show(GetEventTypeRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/event_types/{$uuid}/", $request);

        return response()->json([
            'event_type' => new CalendlyEventType($response),
        ]);
    }
}
