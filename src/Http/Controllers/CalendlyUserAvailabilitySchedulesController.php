<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexUserAvailabilitySchedulesRequest;
use JsonResponse;
use ShowUserAvailabilityScheduleRequest;
use Typedin\LaravelCalendly\Entities\CalendlyUserAvailabilitySchedule;

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
        $response = $this->api->get("/user_availability_schedules/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'user_availability_schedule' => new CalendlyUserAvailabilitySchedule($response),
        ]);
    }
}
