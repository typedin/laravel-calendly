<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserAvailabilitySchedulesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowUserAvailabilityScheduleRequest;

class CalendlyUserAvailabilitySchedulesController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserAvailabilitySchedulesRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_availability_schedules/', $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\AvailabilitySchedule::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'user_availability_schedules' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $response = $this->api->get("/user_availability_schedules/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'availability_schedule' => new \Typedin\LaravelCalendly\Models\AvailabilitySchedule(...$response->json('resource')),
        ]);
    }
}
