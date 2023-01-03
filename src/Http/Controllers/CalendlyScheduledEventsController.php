<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\GetScheduledEventRequest;
use Typedin\LaravelCalendly\Http\IndexScheduledEventRequest;

class CalendlyScheduledEventsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/", $request);

        $all = collect($response["collection"])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent::class)->all();
        return response()->json([
        "scheduled_events" => $all,
        ]);
    }

    public function show(GetScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$uuid}/", $request);
        return response()->json([
        "scheduled_event" => new \Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent($response),
        ]);
    }
}
