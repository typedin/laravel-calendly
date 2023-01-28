<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use IndexScheduledEventInviteesRequest;
use JsonResponse;
use ShowScheduledEventInviteeRequest;
use Typedin\LaravelCalendly\Entities\CalendlyScheduledEventInvitee;

class CalendlyScheduledEventInviteesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventInviteesRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->safe()->only(['uuid'])}/invitees/", $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyScheduledEventInvitee::class)->all();

        return response()->json([
            'scheduled_event_invitees' => $all,
        ]);
    }

    public function show(ShowScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->safe()->only(['event_uuid'])}/invitees/{$request->safe()->only(['invitee_uuid'])}/", $request);

        return response()->json([
            'scheduled_event_invitee' => new CalendlyScheduledEventInvitee($response),
        ]);
    }
}
