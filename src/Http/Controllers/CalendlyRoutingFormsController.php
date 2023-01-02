<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyRoutingFormsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\GetRoutingFormRequest;
use Typedin\LaravelCalendly\Http\IndexRoutingFormRequest;

class CalendlyRoutingFormsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_forms/", $request);

        $all = collect($response["collection"])
        ->mapInto(RoutingForm::class)->all();
        return response()->json([
        "routing_forms" => $all,
        ]);
    }

    public function show(GetRoutingFormRequest $request)
    {
        $response = $this->api->get("/routing_forms/{$uuid}/", $request);
        return response()->json([
        "routingform" => new \Typedin\LaravelCalendly\Entities\RoutingForm($response),
        ]);
    }
}
