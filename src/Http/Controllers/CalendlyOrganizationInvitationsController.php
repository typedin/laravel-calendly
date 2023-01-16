<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
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

    public function create(PostOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->post("/organizations/{$uuid}/invitations/", $request);

        return response()->json([
            'organization_invitation' => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),
        ]);
    }

    public function show(GetOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);

        return response()->json([
            'organization_invitation' => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),
        ]);
    }

    public function destroy(DeleteOrganizationInvitationRequest $request): JsonResponse
    {
        $this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");

        return response()->noContent();
    }
}
