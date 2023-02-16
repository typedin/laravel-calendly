<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormSubmissionRequest;
use Typedin\LaravelCalendly\Models\RoutingFormSubmission;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyRoutingFormSubmissionsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowRoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_form_submissions/{$request->validated("uuid")}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
        "routing_form_submission" => new RoutingFormSubmission(...$response->json("resource")),
        ]);
    }
}
