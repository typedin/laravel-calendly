<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyOrganizationMembership;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Http\Requests\IndexOrganizationMembershipsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowOrganizationMembershipRequest;

class CalendlyOrganizationMembershipsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowOrganizationMembershipRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/organization_memberships/{$uuid}/", $request);

        return response()->json([
            'organization_membership' => new CalendlyOrganizationMembership($response),
        ]);
    }

    public function destroy(DestroyOrganizationMembershipRequest $request): JsonResponse
    {
        $uuid = null;
        $this->api->delete("/organization_memberships/{$uuid}/");

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
