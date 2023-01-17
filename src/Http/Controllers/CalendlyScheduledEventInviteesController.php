<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyScheduledEventInvitee;
use Typedin\LaravelCalendly\Http\Requests\ScheduledEventInviteeRequest;

class CalendlyScheduledEventInviteesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(ScheduledEventInviteeRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/scheduled_events/{$uuid}/invitees/", $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyScheduledEventInvitee::class)->all();

        return response()->json([
            'scheduled_event_invitees' => $all,
        ]);
    }

    public function show(ScheduledEventInviteeRequest $request): JsonResponse
    {
        $event_uuid = null;
        $invitee_uuid = null;
        $response = $this->api->get("/scheduled_events/{$event_uuid}/invitees/{$invitee_uuid}/", $request);

        return response()->json([
            'scheduled_event_invitee' => new CalendlyScheduledEventInvitee($response),
        ]);
    }
}
