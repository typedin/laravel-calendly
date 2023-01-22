<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypeAvailableTimesRequest;

class CalendlyEventTypeAvailableTimesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexEventTypeAvailableTimesRequest $request): JsonResponse
    {
        $response = $this->api->get("/event_type_available_times/", $request);

        $all = collect($response["collection"])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyEventTypeAvailableTime::class)->all();

        return response()->json([
        "event_type_available_times" => $all,
        ]);
    }
}
