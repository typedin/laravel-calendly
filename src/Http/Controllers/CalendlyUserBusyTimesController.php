<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexUserBusyTimesRequest;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Models\UserBusyTime;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

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
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->map(fn ($args) => new UserBusyTime(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'user_busy_times' => $all,
            'pagination' => $pagination,
        ]);
    }
}
