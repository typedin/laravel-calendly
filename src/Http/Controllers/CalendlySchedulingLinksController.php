<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\SchedulingLinkRequest;

class CalendlySchedulingLinksController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(SchedulingLinkRequest $request): JsonResponse
    {
        $response = $this->api->post("/scheduling_links/", $request);
        return response()->json([
        "scheduling_link" => new \Typedin\LaravelCalendly\Entities\CalendlySchedulingLink($response),
        ]);
    }
}
