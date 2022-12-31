<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlySchedulingLinksController;

class CalendlySchedulingLinksController extends Illuminate\Routing\Controller
{
    private readonly Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(\Typedin\LaravelCalendly\Http\PostSchedulingLinkRequest $request)
    {
        $this->api->post('/scheduling_links/', $request);
    }
}