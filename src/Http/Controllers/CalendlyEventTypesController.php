<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowEventTypeRequest;
use Typedin\LaravelCalendly\Models\EventType;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyEventTypesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowEventTypeRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_types/{$request->validated('uuid')}/", $request);

        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'event_type' => new EventType(...$response->json('resource')),
        ]);
    }
}
