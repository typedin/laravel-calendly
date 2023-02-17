<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowEventTypeRequest;

class CalendlyEventTypesController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypesRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_types/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->map(fn ($args) => new \Typedin\LaravelCalendly\Models\EventType(...$args));
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'event_types' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_types/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'event_type' => new \Typedin\LaravelCalendly\Models\EventType(...$response->json('resource')),
        ]);
    }
}
