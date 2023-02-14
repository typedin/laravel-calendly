<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowUserAvailabilityScheduleRequest;
use Typedin\LaravelCalendly\Models\UserAvailabilitySchedule;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyUserAvailabilitySchedulesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowUserAvailabilityScheduleRequest $request): JsonResponse
    {
        $response = $this->api->get("/user_availability_schedules/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'user_availability_schedule' => new UserAvailabilitySchedule(...$response->json('resource')),
        ]);
    }
}
