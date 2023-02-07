<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest;

class CalendlyOrganizationInvitationsController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->post("/organizations/{$request->validated('uuid')}/invitations/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'organization_invitation' => new \Typedin\LaravelCalendly\Models\OrganizationInvitation(...$response->json('resource')),
        ]);
    }

    public function show(ShowOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->get("/organizations/{$request->validated('org_uuid')}/invitations/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'organization_invitation' => new \Typedin\LaravelCalendly\Models\OrganizationInvitation(...$response->json('resource')),
        ]);
    }

    public function destroy(DestroyOrganizationInvitationRequest $request): JsonResponse
    {
        $response = $this->api->delete("/organizations/{$request->validated('org_uuid')}/invitations/{$request->validated('uuid')}/");
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->noContent();
    }
}
