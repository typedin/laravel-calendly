<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation;
use Typedin\LaravelCalendly\Http\OrganizationInvitationRequest;

class CalendlyOrganizationInvitationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(OrganizationInvitationRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->post("/organizations/{$uuid}/invitations/", $request);

        return response()->json([
            'organization_invitation' => new CalendlyOrganizationInvitation($response),
        ]);
    }

    public function show(OrganizationInvitationRequest $request): JsonResponse
    {
        $org_uuid = null;
        $uuid = null;
        $response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);

        return response()->json([
            'organization_invitation' => new CalendlyOrganizationInvitation($response),
        ]);
    }

    public function destroy(OrganizationInvitationRequest $request): JsonResponse
    {
        $org_uuid = null;
        $uuid = null;
        $this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");

        return response()->noContent();
    }
}
