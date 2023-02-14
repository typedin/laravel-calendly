<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\IndexOrganizationMembershipsRequest;
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

    public function index(IndexOrganizationMembershipsRequest $request): JsonResponse
    {
        $response = $this->api->get('/organization_memberships/', $request);
        if (! $response->ok()) {
            return ErrorResponseFactory::getJson($response);
        }
        $all = collect($response->collect('collection'))
        ->mapInto(OrganizationMembership::class)->all();
        $pagination = new Pagination(...$response->collect('pagination')->all());

        return response()->json([
            'organization_memberships' => $all,
            'pagination' => $pagination,
        ]);
    }
}
