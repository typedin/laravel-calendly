<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\OrganizationInvitationRequest;

class CalendlyOrganizationInvitationsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(OrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->post("/organizations/{$uuid}/invitations/", $request);
        return response()->json([
        "organization_invitation" => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),
        ]);
    }

    public function show(OrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);
        return response()->json([
        "organization_invitation" => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),
        ]);
    }

    public function destroy(OrganizationInvitationRequest $request): JsonResponse
    {
        $this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");
        return response()->noContent();
    }
}
