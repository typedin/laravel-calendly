<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventRequest;
use Typedin\LaravelCalendly\Models\Event;

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

        if ($response->ok()) {
            $all = collect($response->collect('collection'))
            ->mapInto(Event::class)->all();

            return response()->json([
                'scheduled_events' => $all,
            ]);
        }
    }

    public function show(ShowScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->safe()->only(['uuid'])}/", $request);
        if ($response->ok()) {
            return response()->json([
                'event' => new Event(...$response->json('resource')),
            ]);
        }
    }
}
