<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormSubmissionsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormSubmissionRequest;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Models\RoutingFormSubmission;

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
        if (! $response->ok()) {
        }
        $all = collect($response->collect('collection'))
        ->mapInto(RoutingFormSubmission::class)->all();
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'routing_form_submissions' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowRoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_form_submissions/{$request->validated('uuid')}/", $request);

        return response()->json([
            'routing_form_submission' => new RoutingFormSubmission(...$response->json('resource')),
        ]);
    }
}
