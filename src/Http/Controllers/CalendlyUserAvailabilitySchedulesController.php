<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserAvailabilitySchedulesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowUserAvailabilityScheduleRequest;

class CalendlyUserAvailabilitySchedulesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserAvailabilitySchedulesRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_availability_schedules/', $request);

        $all = collect($response['collection'])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyUserAvailabilitySchedule::class)->all();

        return response()->json([
            'user_availability_schedules' => $all,
        ]);
    }

    public function show(ShowUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $response = $this->api->get("/user_availability_schedules/{$uuid}/", $request);

        return response()->json([
            'user_availability_schedule' => new \Typedin\LaravelCalendly\Entities\CalendlyUserAvailabilitySchedule($response),
        ]);
    }
}
