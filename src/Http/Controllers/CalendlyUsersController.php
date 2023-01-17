<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Typedin\LaravelCalendly\Entities\CalendlyUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\UserRequest;

class CalendlyUsersController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(UserRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/users/{$uuid}/", $request);

        return response()->json([
            'user' => new CalendlyUser($response),
        ]);
    }
}
