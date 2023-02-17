<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Http\Requests\IndexOrganizationMembershipsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowOrganizationMembershipRequest;
use Typedin\LaravelCalendly\Models\OrganizationMembership;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyOrganizationMembershipsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowOrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->get("/organization_memberships/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'organization_membership' => new OrganizationMembership(...$response->json('resource')),
        ]);
    }

    public function destroy(DestroyOrganizationMembershipRequest $request): JsonResponse
    {
        $response = $this->api->delete("/organization_memberships/{$request->validated('uuid')}/");
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return \Illuminate\Support\Facades\Response::json([], 204);
    }

    public function index(IndexOrganizationMembershipsRequest $request): JsonResponse
    {
        $response = $this->api->get('/organization_memberships/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->map(fn ($args) => new OrganizationMembership(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'organization_memberships' => $all,
            'pagination' => $pagination,
        ]);
    }
}
