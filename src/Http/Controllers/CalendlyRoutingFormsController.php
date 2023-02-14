<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormRequest;
use Typedin\LaravelCalendly\Models\RoutingForm;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyRoutingFormsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowRoutingFormRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_forms/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'routing_form' => new RoutingForm(...$response->json('resource')),
        ]);
    }
}
