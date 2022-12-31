<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyRoutingFormsController;

class CalendlyRoutingFormsController extends Illuminate\Routing\Controller
{
    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(\Typedin\LaravelCalendly\Http\IndexRoutingFormRequest $request)
    {
        $response = $this->api->get('/routing_forms/', $request);

        $all = collect($response['collection'])
        ->mapInto(RoutingForm::class)->all();

        return response()->json([
            'routing_forms' => $all,
        ]);
    }

    public function show(\Typedin\LaravelCalendly\Http\GetRoutingFormRequest $request)
    {
        $response = $this->api->get("/routing_forms/{$uuid}/", $request);

        return response()->json([
            'routingform' => new \Typedin\LaravelCalendly\Entities\RoutingForm($response),
        ]);
    }
}
