<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use JsonResponse;
use StoreSchedulingLinkRequest;
use Typedin\LaravelCalendly\Entities\CalendlySchedulingLink;

class CalendlySchedulingLinksController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreSchedulingLinkRequest $request): JsonResponse
    {
        $response = $this->api->post('/scheduling_links/', $request);

        return response()->json([
            'scheduling_link' => new CalendlySchedulingLink($response),
        ]);
    }
}
