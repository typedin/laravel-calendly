<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use DestroyInviteeNoShowRequest;
use JsonResponse;
use ShowInviteeNoShowRequest;
use StoreInviteeNoShowRequest;
use Typedin\LaravelCalendly\Entities\CalendlyInviteeNoShow;

class CalendlyInviteeNoShowsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->get("/invitee_no_shows/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'invitee_no_show' => new CalendlyInviteeNoShow($response),
        ]);
    }

    public function destroy(DestroyInviteeNoShowRequest $request): JsonResponse
    {
        $this->api->delete("/invitee_no_shows/{$request->safe()->only(['uuid'])}/");

        return response()->noContent();
    }

    public function create(StoreInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->post('/invitee_no_shows/', $request);

        return response()->json([
            'invitee_no_show' => new CalendlyInviteeNoShow($response),
        ]);
    }
}
