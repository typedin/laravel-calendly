<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventRequest;
use Typedin\LaravelCalendly\Models\Event;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyScheduledEventsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(
        IndexScheduledEventsRequest $request,
    ): JsonResponse {
        $response = $this->api->get('/scheduled_events/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
            ->map(fn ($args) => new Event(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'events' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(
        ShowScheduledEventRequest $request,
    ): JsonResponse {
        $response = $this->api->get("/scheduled_events/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'event' => new Event(...$response->json('resource')),
        ]);
    }
}
