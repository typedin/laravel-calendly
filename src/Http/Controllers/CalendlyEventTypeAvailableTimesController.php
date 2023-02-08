<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypeAvailableTimesRequest;
use Typedin\LaravelCalendly\Models\EventTypeAvailableTime;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyEventTypeAvailableTimesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypeAvailableTimesRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_type_available_times/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(EventTypeAvailableTime::class)->all();
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'event_type_available_times' => $all,
            'pagination' => $pagination,
        ]);
    }
}
