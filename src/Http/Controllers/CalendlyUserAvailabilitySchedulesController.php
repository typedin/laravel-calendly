<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserAvailabilitySchedulesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowUserAvailabilityScheduleRequest;
use Typedin\LaravelCalendly\Models\AvailabilitySchedule;

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

        if ($response->ok()) {
            $all = collect($response->collect('collection'))
            ->mapInto(AvailabilitySchedule::class)->all();

            return response()->json([
                'user_availability_schedules' => $all,
            ]);
        }
    }

    public function show(ShowUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $response = $this->api->get("/user_availability_schedules/{$request->safe()->only(['uuid'])}/", $request);
        if ($response->ok()) {
            return response()->json([
                'availability_schedule' => new AvailabilitySchedule(...$response->json('resource')),
            ]);
        }
    }
}
