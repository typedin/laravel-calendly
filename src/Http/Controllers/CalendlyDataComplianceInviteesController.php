<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyDataComplianceInviteesController;

use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\PostDataComplianceInviteeRequest;

class CalendlyDataComplianceInviteesController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(PostDataComplianceInviteeRequest $request)
    {
        $this->api->post('/data_compliance/deletion/invitees/', $request);
    }
}
