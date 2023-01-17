<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyScheduledEventCancellation;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\ScheduledEventCancellationRequest;

class CalendlyScheduledEventCancellationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(ScheduledEventCancellationRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->post("/scheduled_events/{$uuid}/cancellation/", $request);

        return response()->json([
            'scheduled_event_cancellation' => new CalendlyScheduledEventCancellation($response),
        ]);
    }
}
