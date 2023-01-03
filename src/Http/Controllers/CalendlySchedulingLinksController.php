<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Controllers\Typedin\LaravelCalendly\Entities\CalendlySchedulingLink;
use Typedin\LaravelCalendly\Http\PostSchedulingLinkRequest;

class CalendlySchedulingLinksController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function create(PostSchedulingLinkRequest $request): JsonResponse
    {
        $response = $this->api->post('/scheduling_links/', $request);

        return response()->json([
            'scheduling_link' => new CalendlySchedulingLink($response),
        ]);
    }
}
