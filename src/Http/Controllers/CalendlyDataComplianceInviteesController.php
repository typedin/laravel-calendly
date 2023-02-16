<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Services\ErrorResponseFactory;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\StoreDataComplianceInviteeRequest;

class CalendlyDataComplianceInviteesController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreDataComplianceInviteeRequest $request): JsonResponse
    {
        $response = $this->api->post("/data_compliance/deletion/invitees/", $request);
        if(!$response->ok()) {return ErrorResponseFactory::getJson($response);}
        return Response::json([], 202);
    }
}
