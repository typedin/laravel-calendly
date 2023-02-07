<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserBusyTimesRequest;

class CalendlyUserBusyTimesController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexUserBusyTimesRequest $request): JsonResponse
    {
        $response = $this->api->get('/user_busy_times/', $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\UserBusyTime::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'user_busy_times' => $all,
            'pagination' => $pagination,
        ]);
    }
}
