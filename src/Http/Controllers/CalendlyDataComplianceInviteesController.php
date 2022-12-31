<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyDataComplianceInviteesController;

class CalendlyDataComplianceInviteesController extends Illuminate\Routing\Controller
{
    private readonly Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(\Typedin\LaravelCalendly\Http\PostDataComplianceInviteeRequest $request)
    {
        $this->api->post('/data_compliance/deletion/invitees/', $request);
    }
}
