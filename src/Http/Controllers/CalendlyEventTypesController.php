<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexEventTypesRequest;
use JsonResponse;
use ShowEventTypeRequest;
use Typedin\LaravelCalendly\Entities\CalendlyEventType;

class CalendlyEventTypesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypesRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_types/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyEventType::class)->all();

        return response()->json([
            'event_types' => $all,
        ]);
    }

    public function show(ShowEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_types/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'event_type' => new CalendlyEventType($response),
        ]);
    }
}
