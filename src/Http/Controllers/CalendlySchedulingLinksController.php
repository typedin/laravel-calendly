<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlySchedulingLinksController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\PostSchedulingLinkRequest;

class CalendlySchedulingLinksController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(PostSchedulingLinkRequest $request): JsonResponse
    {
        $response = $this->api->post("/scheduling_links/", $request);
        return response()->json([
        "scheduling_link" => new \Typedin\LaravelCalendly\Entities\CalendlySchedulingLink($response),
        ]);
    }
}
