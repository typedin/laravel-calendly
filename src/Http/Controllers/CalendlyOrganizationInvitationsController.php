<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\IndexOrganizationInvitationsRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Models\OrganizationInvitation;
use Typedin\LaravelCalendly\Models\Pagination;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

class CalendlyOrganizationInvitationsController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function index(
        IndexOrganizationInvitationsRequest $request,
    ): JsonResponse {
        $response = $this->api->get("/organizations/{$request->validated('uuid')}/invitations/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
            ->map(fn ($args) => new OrganizationInvitation(...$args));
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'organization_invitations' => $all,
            'pagination' => $pagination,
        ]);
    }

    public function create(
        StoreOrganizationInvitationRequest $request,
    ): JsonResponse {
        $response = $this->api->post("/organizations/{$request->validated('uuid')}/invitations/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'organization_invitation' => new OrganizationInvitation(...$response->json('resource')),
        ]);
    }

    public function show(
        ShowOrganizationInvitationRequest $request,
    ): JsonResponse {
        $response = $this->api->get("/organizations/{$request->validated('org_uuid')}/invitations/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'organization_invitation' => new OrganizationInvitation(...$response->json('resource')),
        ]);
    }

    public function destroy(
        DestroyOrganizationInvitationRequest $request,
    ): JsonResponse {
        $response = $this->api->delete("/organizations/{$request->validated('org_uuid')}/invitations/{$request->validated('uuid')}/");
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }

        return Response::json([], 204);
    }
}
