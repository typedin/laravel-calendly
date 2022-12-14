<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyScheduledEventCancellation;
use Typedin\LaravelCalendly\Http\PostScheduledEventCancellationRequest;

class CalendlyScheduledEventCancellationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(PostScheduledEventCancellationRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->post("/scheduled_events/{$uuid}/cancellation/", $request);

        return response()->json([
            'scheduled_event_cancellation' => new CalendlyScheduledEventCancellation($response),
        ]);
    }
}
