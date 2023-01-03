<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyOrganizationMembership;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\DeleteOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Http\GetOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Http\IndexOrganizationMembershipRequest;

class CalendlyOrganizationMembershipsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(GetOrganizationMembershipRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/organization_memberships/{$uuid}/", $request);
        return response()->json([
        "organization_membership" => new CalendlyOrganizationMembership($response),
        ]);
    }

    public function destroy(DeleteOrganizationMembershipRequest $request): JsonResponse
    {
        $uuid = null;
        $this->api->delete("/organization_memberships/{$uuid}/");
        return response()->noContent();
    }

    public function index(IndexOrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->get("/organization_memberships/", $request);

        $all = collect($response["collection"])
        ->mapInto(CalendlyOrganizationMembership::class)->all();
        return response()->json([
        "organization_memberships" => $all,
        ]);
    }
}
