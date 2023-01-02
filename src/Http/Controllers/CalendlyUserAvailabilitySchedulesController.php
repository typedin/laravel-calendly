<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyUserAvailabilitySchedulesController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\GetUserAvailabilityScheduleRequest;
use Typedin\LaravelCalendly\Http\IndexUserAvailabilityScheduleRequest;

class CalendlyUserAvailabilitySchedulesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $response = $this->api->get("/user_availability_schedules/", $request);

        $all = collect($response["collection"])
        ->mapInto(UserAvailabilitySchedule::class)->all();
        return response()->json([
        "user_availability_schedules" => $all,
        ]);
    }

    public function show(GetUserAvailabilityScheduleRequest $request)
    {
        $response = $this->api->get("/user_availability_schedules/{$uuid}/", $request);
        return response()->json([
        "useravailabilityschedule" => new \Typedin\LaravelCalendly\Entities\UserAvailabilitySchedule($response),
        ]);
    }
}
