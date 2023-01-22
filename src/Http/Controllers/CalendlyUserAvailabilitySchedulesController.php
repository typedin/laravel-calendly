<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyUserAvailabilitySchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserAvailabilitySchedulesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowUserAvailabilityScheduleRequest;

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

        $all = collect($response['collection'])
        ->mapInto(CalendlyUserAvailabilitySchedule::class)->all();

        return response()->json([
            'user_availability_schedules' => $all,
        ]);
    }

    public function show(ShowUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/user_availability_schedules/{$uuid}/", $request);

        return response()->json([
            'user_availability_schedule' => new CalendlyUserAvailabilitySchedule($response),
        ]);
    }
}
