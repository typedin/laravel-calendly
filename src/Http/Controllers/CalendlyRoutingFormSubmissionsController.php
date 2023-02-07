<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormSubmissionsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormSubmissionRequest;

class CalendlyRoutingFormSubmissionsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexRoutingFormSubmissionsRequest $request): JsonResponse
    {
        $response = $this->api->get('/routing_form_submissions/', $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\RoutingFormSubmission::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'routing_form_submissions' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowRoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_form_submissions/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'routing_form_submission' => new \Typedin\LaravelCalendly\Models\RoutingFormSubmission(...$response->json('resource')),
        ]);
    }
}
