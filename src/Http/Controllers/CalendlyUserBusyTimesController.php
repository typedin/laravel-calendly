<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyUserBusyTime;
use Typedin\LaravelCalendly\Http\IndexUserBusyTimeRequest;

class CalendlyUserBusyTimesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserBusyTimeRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_busy_times/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyUserBusyTime::class)->all();

        return response()->json([
            'user_busy_times' => $all,
        ]);
    }
}
