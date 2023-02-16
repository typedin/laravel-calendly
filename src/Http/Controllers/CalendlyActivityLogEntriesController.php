<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Services\ErrorResponseFactory;
use Typedin\LaravelCalendly\Models\Entry;
use Typedin\LaravelCalendly\Models\Pagination;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexActivityLogEntriesRequest;

class CalendlyActivityLogEntriesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexActivityLogEntriesRequest $request): JsonResponse
    {
        $response = $this->api->get("/activity_log_entries/", $request);
        if(!$response->ok()) {return ErrorResponseFactory::getJson($response);}
        $all = collect($response->collect("collection"))
        ->map(fn ($args) => new Entry(...$args));
        $pagination = new Pagination(...$response->collect("pagination")->all());
        return response()->json([
        "entries" => $all,
        "pagination" => $pagination,
        ]);
    }
}
