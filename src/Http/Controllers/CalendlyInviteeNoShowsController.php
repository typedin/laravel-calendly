<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyInviteeNoShowsController;

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

    public function show(GetInviteeNoShowRequest $request)
    {
        $response = $this->api->get("/invitee_no_shows/{$uuid}/", $request);

        return response()->json([
            'inviteenoshow' => new \Typedin\LaravelCalendly\Entities\InviteeNoShow($response),
        ]);
    }

    public function destroy(DeleteInviteeNoShowRequest $request)
    {
        $this->api->delete("/invitee_no_shows/{$uuid}/");
    }

    public function post(PostInviteeNoShowRequest $request)
    {
        $this->api->post('/invitee_no_shows/', $request);
    }
}
