<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventsRequest;
use Typedin\LaravelCalendly\Http\Requests\ScheduledEventRequest;

class CalendlyScheduledEventsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventsRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/", $request);

        $all = collect($response["collection"])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent::class)->all();
        return response()->json([
        "scheduled_events" => $all,
        ]);
    }

    public function show(ScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$uuid}/", $request);
        return response()->json([
        "scheduled_event" => new \Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent($response),
        ]);
    }
}
