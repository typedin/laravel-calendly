<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexScheduledEventsRequest;
use JsonResponse;
use ShowScheduledEventRequest;
use Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent;

class CalendlyScheduledEventsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventsRequest $request): JsonResponse
    {
        $response = $this->api->get('/scheduled_events/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyScheduledEvent::class)->all();

        return response()->json([
            'scheduled_events' => $all,
        ]);
    }

    public function show(ShowScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'scheduled_event' => new CalendlyScheduledEvent($response),
        ]);
    }
}
