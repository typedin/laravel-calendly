<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormRequest;

class CalendlyRoutingFormsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormsRequest $request): JsonResponse
    {
        $response = $this->api->get('/routing_forms/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\RoutingForm::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'routing_forms' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowRoutingFormRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_forms/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'routing_form' => new \Typedin\LaravelCalendly\Models\RoutingForm(...$response->json('resource')),
        ]);
    }
}
