<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexRoutingFormSubmissionsRequest;
use JsonResponse;
use ShowRoutingFormSubmissionRequest;
use Typedin\LaravelCalendly\Entities\CalendlyRoutingFormSubmission;

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
        $response = $this->api->get("/routing_form_submissions/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'routing_form_submission' => new CalendlyRoutingFormSubmission($response),
        ]);
    }
}
