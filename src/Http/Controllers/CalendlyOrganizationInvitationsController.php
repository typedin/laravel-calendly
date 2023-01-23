<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest;

class CalendlyOrganizationInvitationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->post("/organizations/{$request->safe()->only(['uuid'])}/invitations/", $request);

        return response()->json([
            'organization_invitation' => new CalendlyOrganizationInvitation($response),
        ]);
    }

    public function show(ShowOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->get("/organizations/{$request->safe()->only(['org_uuid'])}/invitations/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'organization_invitation' => new CalendlyOrganizationInvitation($response),
        ]);
    }

    public function destroy(DestroyOrganizationInvitationRequest $request): JsonResponse
    {
        $this->api->delete("/organizations/{$request->safe()->only(['org_uuid'])}/invitations/{$request->safe()->only(['uuid'])}/");

        return response()->noContent();
    }
}
