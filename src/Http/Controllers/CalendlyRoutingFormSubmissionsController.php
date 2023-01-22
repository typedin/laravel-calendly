<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyRoutingFormSubmission;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormSubmissionsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormSubmissionRequest;

class CalendlyRoutingFormSubmissionsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormSubmissionsRequest $request): JsonResponse
    {
        $response = $this->api->get('/routing_form_submissions/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyRoutingFormSubmission::class)->all();

        return response()->json([
            'routing_form_submissions' => $all,
        ]);
    }

    public function show(ShowRoutingFormSubmissionRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/routing_form_submissions/{$uuid}/", $request);

        return response()->json([
            'routing_form_submission' => new CalendlyRoutingFormSubmission($response),
        ]);
    }
}
