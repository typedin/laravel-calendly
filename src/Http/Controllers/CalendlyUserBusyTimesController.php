<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexUserBusyTimesRequest;
use JsonResponse;
use Typedin\LaravelCalendly\Entities\CalendlyUserBusyTime;

class CalendlyUserBusyTimesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserBusyTimesRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_busy_times/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyUserBusyTime::class)->all();

        return response()->json([
            'user_busy_times' => $all,
        ]);
    }
}
