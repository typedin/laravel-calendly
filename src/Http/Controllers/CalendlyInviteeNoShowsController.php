<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyInviteeNoShow;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreInviteeNoShowRequest;

class CalendlyInviteeNoShowsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowInviteeNoShowRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/invitee_no_shows/{$uuid}/", $request);
        return response()->json([
        "invitee_no_show" => new CalendlyInviteeNoShow($response),
        ]);
    }

    public function destroy(DestroyInviteeNoShowRequest $request): JsonResponse
    {
        $uuid = null;
        $this->api->delete("/invitee_no_shows/{$uuid}/");
        return response()->noContent();
    }

    public function create(StoreInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->post("/invitee_no_shows/", $request);
        return response()->json([
        "invitee_no_show" => new CalendlyInviteeNoShow($response),
        ]);
    }
}
