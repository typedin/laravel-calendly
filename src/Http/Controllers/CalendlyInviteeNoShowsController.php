<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreInviteeNoShowRequest;
use Typedin\LaravelCalendly\Models\InviteeNoShow;

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
        if ($response->ok()) {
            return response()->json([
                'invitee_no_show' => new InviteeNoShow(...$response->json('resource')),
            ]);
        }
    }

    public function destroy(DestroyInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->delete("/invitee_no_shows/{$request->safe()->only(['uuid'])}/");
        if ($response->ok()) {
            return response()->noContent();
        }
    }

    public function create(StoreInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->post('/invitee_no_shows/', $request);
        if ($response->ok()) {
            return response()->json([
                'invitee_no_show' => new InviteeNoShow(...$response->json('resource')),
            ]);
        }
    }
}
