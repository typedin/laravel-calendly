<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyEventTypeAvailableTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypeAvailableTimesRequest;

class CalendlyEventTypeAvailableTimesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypeAvailableTimesRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_type_available_times/", $request);

        $all = collect($response["collection"])
        ->mapInto(CalendlyEventTypeAvailableTime::class)->all();
        return response()->json([
        "event_type_available_times" => $all,
        ]);
    }
}
