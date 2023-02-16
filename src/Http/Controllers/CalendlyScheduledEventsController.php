<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Services\ErrorResponseFactory;
use Typedin\LaravelCalendly\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventRequest;

class CalendlyScheduledEventsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowScheduledEventRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated("uuid")}/", $request);
        if(!$response->ok()) {return ErrorResponseFactory::getJson($response);}
        return response()->json([
        "event" => new Event(...$response->json("resource")),
        ]);
    }
}
