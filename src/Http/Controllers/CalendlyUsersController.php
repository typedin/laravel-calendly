<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyUser;
use Typedin\LaravelCalendly\Http\Requests\ShowUserRequest;

class CalendlyUsersController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowUserRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/users/{$uuid}/", $request);

        return response()->json([
            'user' => new CalendlyUser($response),
        ]);
    }
}
