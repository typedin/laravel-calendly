<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Entities\CalendlyUser;
use Typedin\LaravelCalendly\Http\GetUserRequest;

class CalendlyUsersController extends Controller
{
    public function __construct(private readonly CalendlyApiInterface $api)
    {
    }

    public function show(GetUserRequest $request): JsonResponse
    {
        $uuid = null;
        $response = $this->api->get("/users/{$uuid}/", $request);

        return response()->json([
            'user' => new CalendlyUser($response),
        ]);
    }
}
