<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use DestroyOrganizationMembershipRequest;
use IndexOrganizationMembershipsRequest;
use JsonResponse;
use ShowOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Entities\CalendlyOrganizationMembership;

class CalendlyOrganizationMembershipsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowOrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->get("/organization_memberships/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'organization_membership' => new CalendlyOrganizationMembership($response),
        ]);
    }

    public function destroy(DestroyOrganizationMembershipRequest $request): JsonResponse
    {
        $this->api->delete("/organization_memberships/{$request->safe()->only(['uuid'])}/");

        return response()->noContent();
    }

    public function index(IndexOrganizationMembershipsRequest $request): JsonResponse
    {
        $response = $this->api->get('/organization_memberships/', $request);

        $all = collect($response['collection'])
        ->mapInto(CalendlyOrganizationMembership::class)->all();

        return response()->json([
            'organization_memberships' => $all,
        ]);
    }
}
