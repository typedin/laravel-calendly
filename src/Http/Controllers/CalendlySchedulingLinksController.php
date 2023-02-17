<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\StoreSchedulingLinkRequest;

class CalendlySchedulingLinksController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreSchedulingLinkRequest $request): JsonResponse
    {
        $response = $this->api->post('/scheduling_links/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'booking_url' => new \Typedin\LaravelCalendly\Models\BookingUrl(...$response->json('resource')),
        ]);
    }
}
