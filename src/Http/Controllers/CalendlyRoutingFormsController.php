<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexRoutingFormsRequest;
use JsonResponse;
use ShowRoutingFormRequest;
use Typedin\LaravelCalendly\Entities\CalendlyRoutingForm;

class CalendlyRoutingFormsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormsRequest $request): JsonResponse
    {
        $response = $this->api->get('/routing_forms/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyRoutingForm::class)->all();

        return response()->json([
            'routing_forms' => $all,
        ]);
    }

    public function show(ShowRoutingFormRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_forms/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'routing_form' => new CalendlyRoutingForm($response),
        ]);
    }
}
