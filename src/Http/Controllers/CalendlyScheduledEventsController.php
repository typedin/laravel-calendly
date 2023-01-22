<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventRequest;

class CalendlyScheduledEventsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventsRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/", $request);

        $all = collect($response["collection"])
        ->mapInto(CalendlyScheduledEvent::class)->all();
        return response()->json([
        "scheduled_events" => $all,
        ]);
    }

    public function show(ShowScheduledEventRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/scheduled_events/{$uuid}/", $request);
        return response()->json([
        "scheduled_event" => new CalendlyScheduledEvent($response),
        ]);
    }
}
