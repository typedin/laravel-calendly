<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowEventTypeRequest;
use Typedin\LaravelCalendly\Models\EventType;

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

        if ($response->ok()) {
            $all = collect($response->collect('collection'))
            ->mapInto(EventType::class)->all();

            return response()->json([
                'event_types' => $all,
            ]);
        }
    }

    public function show(ShowEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_types/{$request->safe()->only(['uuid'])}/", $request);
        if ($response->ok()) {
            return response()->json([
                'event_type' => new EventType(...$response->json('resource')),
            ]);
        }
    }
}
