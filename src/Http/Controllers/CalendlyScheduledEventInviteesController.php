<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventInviteesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventInviteeRequest;

class CalendlyScheduledEventInviteesController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventInviteesRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated('uuid')}/invitees/", $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(\Typedin\LaravelCalendly\Models\Invitee::class)->all();
        $pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'scheduled_event_invitees' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated('event_uuid')}/invitees/{$request->validated('invitee_uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'invitee' => new \Typedin\LaravelCalendly\Models\Invitee(...$response->json('resource')),
        ]);
    }
}
