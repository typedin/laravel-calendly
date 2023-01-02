<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyEventTypesController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\GetEventTypeRequest;
use Typedin\LaravelCalendly\Http\IndexEventTypeRequest;

class CalendlyEventTypesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_types/', $request);

        $all = collect($response['collection'])
        ->mapInto(EventType::class)->all();

        return response()->json([
            'event_types' => $all,
        ]);
    }

    public function show(GetEventTypeRequest $request)
    {
        $response = $this->api->get("/event_types/{$uuid}/", $request);

        return response()->json([
            'eventtype' => new \Typedin\LaravelCalendly\Entities\EventType($response),
        ]);
    }
}
