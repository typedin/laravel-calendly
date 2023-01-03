<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyRoutingFormSubmissionsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\GetRoutingFormSubmissionRequest;
use Typedin\LaravelCalendly\Http\IndexRoutingFormSubmissionRequest;

class CalendlyRoutingFormSubmissionsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_form_submissions/", $request);

        $all = collect($response["collection"])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyRoutingFormSubmission::class)->all();
        return response()->json([
        "routing_form_submissions" => $all,
        ]);
    }

    public function show(GetRoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_form_submissions/{$uuid}/", $request);
        return response()->json([
        "routing_form_submission" => new \Typedin\LaravelCalendly\Entities\CalendlyRoutingFormSubmission($response),
        ]);
    }
}
