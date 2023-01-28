<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexEventTypeAvailableTimesRequest;
use JsonResponse;
use Typedin\LaravelCalendly\Entities\CalendlyEventTypeAvailableTime;

class CalendlyEventTypeAvailableTimesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypeAvailableTimesRequest $request): JsonResponse
    {
        $response = $this->api->get('/event_type_available_times/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyEventTypeAvailableTime::class)->all();

        return response()->json([
            'event_type_available_times' => $all,
        ]);
    }
}
