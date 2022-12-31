<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyUserAvailabilitySchedulesController;

class CalendlyUserAvailabilitySchedulesController extends Illuminate\Routing\Controller
{
    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(\Typedin\LaravelCalendly\Http\IndexUserAvailabilityScheduleRequest $request)
    {
        $response = $this->api->get('/user_availability_schedules/', $request);

        $all = collect($response['collection'])
        ->mapInto(UserAvailabilitySchedule::class)->all();

        return response()->json([
            'user_availability_schedules' => $all,
        ]);
    }

    public function show(\Typedin\LaravelCalendly\Http\GetUserAvailabilityScheduleRequest $request)
    {
        $response = $this->api->get("/user_availability_schedules/{$uuid}/", $request);

        return response()->json([
            'useravailabilityschedule' => new \Typedin\LaravelCalendly\Entities\UserAvailabilitySchedule($response),
        ]);
    }
}
