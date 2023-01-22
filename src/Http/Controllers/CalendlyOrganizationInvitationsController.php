<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest;

class CalendlyOrganizationInvitationsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->post("/organizations/{$uuid}/invitations/", $request);

        return response()->json([
            'organization_invitation' => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),
        ]);
    }

    public function show(ShowOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->get("/organizations/{$org_uuid}/invitations/{$uuid}/", $request);

        return response()->json([
            'organization_invitation' => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),
        ]);
    }

    public function destroy(DestroyOrganizationInvitationRequest $request): JsonResponse
    {
        $this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");

        return response()->noContent();
    }
}
