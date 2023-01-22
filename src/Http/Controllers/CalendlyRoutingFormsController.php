<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyRoutingForm;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormRequest;

class CalendlyRoutingFormsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormsRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_forms/", $request);

        $all = collect($response["collection"])
        ->mapInto(CalendlyRoutingForm::class)->all();
        return response()->json([
        "routing_forms" => $all,
        ]);
    }

    public function show(ShowRoutingFormRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/routing_forms/{$uuid}/", $request);
        return response()->json([
        "routing_form" => new CalendlyRoutingForm($response),
        ]);
    }
}
