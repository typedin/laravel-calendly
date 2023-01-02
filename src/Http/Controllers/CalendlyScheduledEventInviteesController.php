<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventInviteesController;

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

        $all = collect($response["collection"])
        ->mapInto(ScheduledEventInvitee::class)->all();
        return response()->json([
        "scheduled_event_invitees" => $all,
        ]);
    }

    public function show(GetScheduledEventInviteeRequest $request)
    {
        $response = $this->api->get("/scheduled_events/{$event_uuid}/invitees/{$invitee_uuid}/", $request);
        return response()->json([
        "scheduledeventinvitee" => new \Typedin\LaravelCalendly\Entities\ScheduledEventInvitee($response),
        ]);
    }
}
