<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventInviteeRequest;
use Typedin\LaravelCalendly\Models\ScheduledEventInvitee;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyScheduledEventInviteesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated('event_uuid')}/invitees/{$request->validated('invitee_uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'scheduled_event_invitee' => new ScheduledEventInvitee(...$response->json('resource')),
        ]);
    }
}
