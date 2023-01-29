<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormRequest;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Models\RoutingForm;

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

        if ($response->ok()) {
            $all = collect($response->collect('collection'))
            ->mapInto(RoutingForm::class)->all();
            $pagination = new Pagination(...$response->collect('pagination')->all());

            return response()->json([
                'routing_forms' => $all,
                'pagination' => $pagination,
            ]);
        }
    }

    public function show(ShowRoutingFormRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_forms/{$request->safe()->only(['uuid'])}/", $request);
        if ($response->ok()) {
            return response()->json([
                'routing_form' => new RoutingForm(...$response->json('resource')),
            ]);
        }
    }
}
