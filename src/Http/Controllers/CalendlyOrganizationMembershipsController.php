<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationMembershipsController;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\DeleteOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Http\GetOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Http\IndexOrganizationMembershipRequest;

class CalendlyOrganizationMembershipsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(GetOrganizationMembershipRequest $request)
    {
        $response = $this->api->get("/organization_memberships/{$uuid}/", $request);
        return response()->json([
        "organizationmembership" => new \Typedin\LaravelCalendly\Entities\OrganizationMembership($response),
        ]);
    }

    public function destroy(DeleteOrganizationMembershipRequest $request)
    {
        $this->api->delete("/organization_memberships/{$uuid}/");
    }

    public function index(IndexOrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->get("/organization_memberships/", $request);

        $all = collect($response["collection"])
        ->mapInto(OrganizationMembership::class)->all();
        return response()->json([
        "organization_memberships" => $all,
        ]);
    }
}
