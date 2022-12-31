<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventCancellationsController;

class CalendlyScheduledEventCancellationsController extends Illuminate\Routing\Controller
{
    private readonly Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(\Typedin\LaravelCalendly\Http\PostScheduledEventCancellationRequest $request)
    {
        $uuid = null;
        $this->api->post("/scheduled_events/{$uuid}/cancellation/", $request);
    }
}
