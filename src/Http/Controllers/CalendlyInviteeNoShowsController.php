<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyInviteeNoShowsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\DeleteInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\GetInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\PostInviteeNoShowRequest;

class CalendlyInviteeNoShowsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(GetInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->get("/invitee_no_shows/{$uuid}/", $request);

        return response()->json([
            'invitee_no_show' => new \Typedin\LaravelCalendly\Entities\InviteeNoShow($response),
        ]);
    }

    public function destroy(DeleteInviteeNoShowRequest $request): JsonResponse
    {
        $this->api->delete("/invitee_no_shows/{$uuid}/");

        return response()->noContent();
    }

    public function create(PostInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->post('/invitee_no_shows/', $request);

        return response()->json([
            'invitee_no_show' => new \Typedin\LaravelCalendly\Entities\InviteeNoShow($response),
        ]);
    }
}
