<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use JsonResponse;
use StoreScheduledEventCancellationRequest;
use Typedin\LaravelCalendly\Entities\CalendlyScheduledEventCancellation;

class CalendlyScheduledEventCancellationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreScheduledEventCancellationRequest $request): JsonResponse
    {
        $response = $this->api->post("/scheduled_events/{$request->safe()->only(['uuid'])}/cancellation/", $request);

        return response()->json([
            'scheduled_event_cancellation' => new CalendlyScheduledEventCancellation($response),
        ]);
    }
}
