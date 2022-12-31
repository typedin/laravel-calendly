<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyEventTypesController;

class CalendlyEventTypesController extends Illuminate\Routing\Controller
{
    private readonly Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(\Typedin\LaravelCalendly\Http\IndexEventTypeRequest $request)
    {
        $response = $this->api->get('/event_types/', $request);

        $all = collect($response['collection'])
        ->mapInto(EventType::class)->all();

        return response()->json([
            'event_types' => $all,
        ]);
    }

    public function show(\Typedin\LaravelCalendly\Http\GetEventTypeRequest $request)
    {
        $uuid = null;
        $response = $this->api->get("/event_types/{$uuid}/", $request);

        return response()->json([
            'eventtype' => new \Typedin\LaravelCalendly\Entities\EventType($response),
        ]);
    }
}
