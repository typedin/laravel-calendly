<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventInviteesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventInviteeRequest;
use Typedin\LaravelCalendly\Models\Invitee;
use Typedin\LaravelCalendly\Models\Pagination;

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

        if ($response->ok()) {
            $all = collect($response->collect('collection'))
            ->mapInto(Invitee::class)->all();
            $pagination = new Pagination(...$response->collect('pagination')->all());

            return response()->json([
                'scheduled_event_invitees' => $all,
                'pagination' => $pagination,
            ]);
        }
    }

    public function show(ShowScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->safe()->only(['event_uuid'])}/invitees/{$request->safe()->only(['invitee_uuid'])}/", $request);
        if ($response->ok()) {
            return response()->json([
                'invitee' => new Invitee(...$response->json('resource')),
            ]);
        }
    }
}
