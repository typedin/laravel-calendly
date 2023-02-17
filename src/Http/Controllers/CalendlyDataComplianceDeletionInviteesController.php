<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\StoreDataComplianceDeletionInviteeRequest;

class CalendlyDataComplianceDeletionInviteesController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function create(StoreDataComplianceDeletionInviteeRequest $request): JsonResponse
    {
        $response = $this->api->post('/data_compliance/deletion/invitees/', $request);
        if (! $response->ok()) {
            return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);
        }

        return \Illuminate\Support\Facades\Response::json([], 202);
    }
}
