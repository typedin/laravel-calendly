<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyScheduledEventCancellationsController;

use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\PostScheduledEventCancellationRequest;

class CalendlyScheduledEventCancellationsController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function post(PostScheduledEventCancellationRequest $request)
    {
        $this->api->post("/scheduled_events/{$uuid}/cancellation/", $request);
    }
}
