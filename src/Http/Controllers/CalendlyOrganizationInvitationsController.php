<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController;

use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\DeleteOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\GetOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\PostOrganizationInvitationRequest;

class CalendlyOrganizationInvitationsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(PostOrganizationInvitationRequest $request)
    {
        $this->api->post("/organizations/{$uuid}/invitations/", $request);
    }

    public function show(GetOrganizationInvitationRequest $request)
    {
        $response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);
        return response()->json([
        "organizationinvitation" => new \Typedin\LaravelCalendly\Entities\OrganizationInvitation($response),
        ]);
    }

    public function destroy(DeleteOrganizationInvitationRequest $request)
    {
        $this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");
    }
}
