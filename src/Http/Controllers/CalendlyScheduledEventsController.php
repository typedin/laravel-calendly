<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyScheduledEvent;
use Typedin\LaravelCalendly\Http\GetScheduledEventRequest;
use Typedin\LaravelCalendly\Http\IndexScheduledEventRequest;

class CalendlyScheduledEventsController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function index(IndexScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get('/scheduled_events/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyScheduledEvent::class)->all();

        return response()->json([
            'scheduled_events' => $all,
        ]);
    }

    public function show(GetScheduledEventRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/scheduled_events/{$uuid}/", $request);

        return response()->json([
            'scheduled_event' => new CalendlyScheduledEvent($response),
        ]);
    }
}
