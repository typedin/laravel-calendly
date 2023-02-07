<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexActivityLogEntriesRequest;

class CalendlyActivityLogEntriesController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexActivityLogEntriesRequest $request): JsonResponse
    {
        $response = $this->api->get('/activity_log_entries/', $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\Entry::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'activity_log_entries' => $all,
            'pagination' => $pagination,
        ]);
    }
}
