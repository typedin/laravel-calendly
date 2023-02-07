<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreInviteeNoShowRequest;

class CalendlyInviteeNoShowsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->get("/invitee_no_shows/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'invitee_no_show' => new \Typedin\LaravelCalendly\Models\InviteeNoShow(...$response->json('resource')),
        ]);
    }

    public function destroy(DestroyInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->delete("/invitee_no_shows/{$request->validated('uuid')}/");
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->noContent();
    }

    public function create(StoreInviteeNoShowRequest $request): JsonResponse
    {
        $response = $this->api->post('/invitee_no_shows/', $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'invitee_no_show' => new \Typedin\LaravelCalendly\Models\InviteeNoShow(...$response->json('resource')),
        ]);
    }
}
