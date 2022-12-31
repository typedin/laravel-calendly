<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyInviteeNoShowsController;

class CalendlyInviteeNoShowsController extends Illuminate\Routing\Controller
{
    public $api;
    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(\Typedin\LaravelCalendly\Http\GetInviteeNoShowRequest $request)
    {
        $uuid = null;
        $response = $this->api->get("/invitee_no_shows/{$uuid}/", $request);

        return response()->json([
            'inviteenoshow' => new \Typedin\LaravelCalendly\Entities\InviteeNoShow($response),
        ]);
    }

    public function destroy(\Typedin\LaravelCalendly\Http\DeleteInviteeNoShowRequest $request)
    {
        $uuid = null;
        $this->api->delete("/invitee_no_shows/{$uuid}/");
    }

    public function post(\Typedin\LaravelCalendly\Http\PostInviteeNoShowRequest $request)
    {
        $this->api->post('/invitee_no_shows/', $request);
    }
}
