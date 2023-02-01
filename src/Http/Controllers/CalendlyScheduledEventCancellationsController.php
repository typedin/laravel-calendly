<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\StoreScheduledEventCancellationRequest;
use Typedin\LaravelCalendly\Models\Cancellation;

class CalendlyScheduledEventCancellationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreScheduledEventCancellationRequest $request): JsonResponse
    {
        $response = $this->api->post("/scheduled_events/{$request->validated('uuid')}/cancellation/", $request);

        return response()->json([
            'cancellation' => new Cancellation(...$response->json('resource')),
        ]);
    }
}
