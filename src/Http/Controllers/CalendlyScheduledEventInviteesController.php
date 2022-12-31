<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventInviteesController;

class CalendlyScheduledEventInviteesController extends Illuminate\Routing\Controller
{
    private readonly Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(\Typedin\LaravelCalendly\Http\IndexScheduledEventInviteeRequest $request)
    {
        $uuid = null;
        $response = $this->api->get("/scheduled_events/{$uuid}/invitees/", $request);

        $all = collect($response['collection'])
        ->mapInto(ScheduledEventInvitee::class)->all();

        return response()->json([
            'scheduled_event_invitees' => $all,
        ]);
    }

    public function show(\Typedin\LaravelCalendly\Http\GetScheduledEventInviteeRequest $request)
    {
        $event_uuid = null;
        $invitee_uuid = null;
        $response = $this->api->get("/scheduled_events/{$event_uuid}/invitees/{$invitee_uuid}/", $request);

        return response()->json([
            'scheduledeventinvitee' => new \Typedin\LaravelCalendly\Entities\ScheduledEventInvitee($response),
        ]);
    }
}
