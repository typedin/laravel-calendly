<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\OrganizationMembershipRequest;

class CalendlyOrganizationMembershipsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(OrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->get("/organization_memberships/{$uuid}/", $request);
        return response()->json([
        "organization_membership" => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationMembership($response),
        ]);
    }

    public function destroy(OrganizationMembershipRequest $request): JsonResponse
    {
        $this->api->delete("/organization_memberships/{$uuid}/");
        return response()->noContent();
    }

    public function index(OrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->get("/organization_memberships/", $request);

        $all = collect($response["collection"])
        ->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyOrganizationMembership::class)->all();
        return response()->json([
        "organization_memberships" => $all,
        ]);
    }
}
