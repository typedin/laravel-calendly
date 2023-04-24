<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexScheduledEventInviteesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowScheduledEventInviteeRequest;
use Typedin\LaravelCalendly\Models\Invitee;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyScheduledEventInviteesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(IndexScheduledEventInviteesRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated('uuid')}/invitees/", $request);
        if (! $response->ok()) {
        return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
            ->map(fn ($args) => new Invitee(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'invitees' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function show(ShowScheduledEventInviteeRequest $request): JsonResponse
    {
        $response = $this->api->get("/scheduled_events/{$request->validated('event_uuid')}/invitees/{$request->validated('invitee_uuid')}/", $request);
        if (! $response->ok()) {
        return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'invitee' => new Invitee(...$response->json('resource')),
        ]);
    }
}
