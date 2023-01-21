<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\DataComplianceInviteeRequest;

class CalendlyDataComplianceInviteesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(DataComplianceInviteeRequest $request): JsonResponse
    {
        $response = $this->api->post("/data_compliance/deletion/invitees/", $request);
        return response()->json([
        "data_compliance_invitee" => new \Typedin\LaravelCalendly\Entities\CalendlyDataComplianceInvitee($response),
        ]);
    }
}
