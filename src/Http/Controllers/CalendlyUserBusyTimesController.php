<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserBusyTimesRequest;

class CalendlyUserBusyTimesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserBusyTimesRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_busy_times/', $request);

        $all = collect($response['collection'])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyUserBusyTime::class)->all();

        return response()->json([
            'user_busy_times' => $all,
        ]);
    }
}
