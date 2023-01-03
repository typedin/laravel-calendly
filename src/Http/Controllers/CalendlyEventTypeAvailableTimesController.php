<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyEventTypeAvailableTime;
use Typedin\LaravelCalendly\Http\IndexEventTypeAvailableTimeRequest;

class CalendlyEventTypeAvailableTimesController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function index(IndexEventTypeAvailableTimeRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_type_available_times/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyEventTypeAvailableTime::class)->all();

        return response()->json([
            'event_type_available_times' => $all,
        ]);
    }
}
