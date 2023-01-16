<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\GetScheduledEventInviteeRequest;
use Typedin\LaravelCalendly\Http\IndexScheduledEventInviteeRequest;

class CalendlyScheduledEventInviteesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$uuid}/invitees/", $request);

        $all = collect($response['collection'])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyScheduledEventInvitee::class)->all();

        return response()->json([
            'scheduled_event_invitees' => $all,
        ]);
    }

    public function show(GetScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$event_uuid}/invitees/{$invitee_uuid}/", $request);

        return response()->json([
            'scheduled_event_invitee' => new \Typedin\LaravelCalendly\Entities\CalendlyScheduledEventInvitee($response),
        ]);
    }
}
