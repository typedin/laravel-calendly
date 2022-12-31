<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyRoutingFormSubmissionsController;

class CalendlyRoutingFormSubmissionsController extends Illuminate\Routing\Controller
{
    private readonly Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(\Typedin\LaravelCalendly\Http\IndexRoutingFormSubmissionRequest $request)
    {
        $response = $this->api->get('/routing_form_submissions/', $request);

        $all = collect($response['collection'])
        ->mapInto(RoutingFormSubmission::class)->all();

        return response()->json([
            'routing_form_submissions' => $all,
        ]);
    }

    public function show(\Typedin\LaravelCalendly\Http\GetRoutingFormSubmissionRequest $request)
    {
        $uuid = null;
        $response = $this->api->get("/routing_form_submissions/{$uuid}/", $request);

        return response()->json([
            'routingformsubmission' => new \Typedin\LaravelCalendly\Entities\RoutingFormSubmission($response),
        ]);
    }
}