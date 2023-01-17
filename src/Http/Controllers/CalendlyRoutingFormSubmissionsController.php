<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyRoutingFormSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\RoutingFormSubmissionRequest;

class CalendlyRoutingFormSubmissionsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(RoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get('/routing_form_submissions/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyRoutingFormSubmission::class)->all();

        return response()->json([
            'routing_form_submissions' => $all,
        ]);
    }

    public function show(RoutingFormSubmissionRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/routing_form_submissions/{$uuid}/", $request);

        return response()->json([
            'routing_form_submission' => new CalendlyRoutingFormSubmission($response),
        ]);
    }
}
