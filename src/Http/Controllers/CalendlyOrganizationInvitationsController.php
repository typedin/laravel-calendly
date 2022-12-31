<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController;

class CalendlyOrganizationInvitationsController extends Illuminate\Routing\Controller
{
    public $api;
    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(\Typedin\LaravelCalendly\Http\PostOrganizationInvitationRequest $request)
    {
        $uuid = null;
        $this->api->post("/organizations/{$uuid}/invitations/", $request);
    }

    public function show(\Typedin\LaravelCalendly\Http\GetOrganizationInvitationRequest $request)
    {
        $org_uuid = null;
        $uuid = null;
        $response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);

        return response()->json([
            'organizationinvitation' => new \Typedin\LaravelCalendly\Entities\OrganizationInvitation($response),
        ]);
    }

    public function destroy(\Typedin\LaravelCalendly\Http\DeleteOrganizationInvitationRequest $request)
    {
        $org_uuid = null;
        $uuid = null;
        $this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");
    }
}
