<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserAvailabilitySchedulesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowUserAvailabilityScheduleRequest;
use Typedin\LaravelCalendly\Models\AvailabilitySchedule;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyUserAvailabilitySchedulesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserAvailabilitySchedulesRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_availability_schedules/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(AvailabilitySchedule::class)->all();
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'user_availability_schedules' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $response = $this->api->get("/user_availability_schedules/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'availability_schedule' => new AvailabilitySchedule(...$response->json('resource')),
        ]);
    }
}
