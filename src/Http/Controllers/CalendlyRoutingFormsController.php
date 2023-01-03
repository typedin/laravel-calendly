<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyRoutingForm;
use Typedin\LaravelCalendly\Http\GetRoutingFormRequest;
use Typedin\LaravelCalendly\Http\IndexRoutingFormRequest;

class CalendlyRoutingFormsController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function index(IndexRoutingFormRequest $request): JsonResponse
    {
        $response = $this->api->get('/routing_forms/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyRoutingForm::class)->all();

        return response()->json([
            'routing_forms' => $all,
        ]);
    }

    public function show(GetRoutingFormRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/routing_forms/{$uuid}/", $request);

        return response()->json([
            'routing_form' => new CalendlyRoutingForm($response),
        ]);
    }
}
