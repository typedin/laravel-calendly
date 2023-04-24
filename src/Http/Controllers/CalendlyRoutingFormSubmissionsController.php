<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexRoutingFormSubmissionsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowRoutingFormSubmissionRequest;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Models\RoutingFormSubmission;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

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
        return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
            ->map(fn ($args) => new RoutingFormSubmission(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'routing_form_submissions' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowRoutingFormSubmissionRequest $request): JsonResponse
    {
        $response = $this->api->get("/routing_form_submissions/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
        return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'routing_form_submission' => new RoutingFormSubmission(...$response->json('resource')),
        ]);
    }
}
