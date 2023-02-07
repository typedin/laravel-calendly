<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\StoreScheduledEventCancellationRequest;

class CalendlyScheduledEventCancellationsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreScheduledEventCancellationRequest $request): JsonResponse
    {
        $response = $this->api->post("/scheduled_events/{$request->validated('uuid')}/cancellation/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'cancellation' => new \Typedin\LaravelCalendly\Models\Cancellation(...$response->json('resource')),
        ]);
    }
}
