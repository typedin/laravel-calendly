<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\StoreSchedulingLinkRequest;
use Typedin\LaravelCalendly\Models\BookingUrl;

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
            'booking_url' => new BookingUrl(...$response->json('resource')),
        ]);
    }
}
