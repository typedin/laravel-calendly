<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\UserRequest;

class CalendlyUsersController extends Controller
{
    private CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(UserRequest $request): JsonResponse
    {
        $response = $this->api->get("/users/{$uuid}/", $request);

        return response()->json([
            'user' => new \Typedin\LaravelCalendly\Entities\CalendlyUser($response),
        ]);
    }
}
