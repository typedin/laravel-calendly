<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlySchedulingLinksController;

use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\PostSchedulingLinkRequest;

class CalendlySchedulingLinksController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(PostSchedulingLinkRequest $request)
    {
        $this->api->post('/scheduling_links/', $request);
    }
}
