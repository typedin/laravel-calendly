<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventRequest;

class CalendlyScheduledEventsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventsRequest $request): JsonResponse
    {
        $response = $this->api->get('/scheduled_events/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\Event::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'scheduled_events' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'event' => new \Typedin\LaravelCalendly\Models\Event(...$response->json('resource')),
        ]);
    }
}
