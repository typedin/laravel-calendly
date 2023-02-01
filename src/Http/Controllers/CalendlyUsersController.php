<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowUserRequest;
use Typedin\LaravelCalendly\Models\User;

class CalendlyUsersController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowUserRequest $request): JsonResponse
    {
        $response = $this->api->get("/users/{$request->validated('uuid')}/", $request);

        return response()->json([
            'user' => new User(...$response->json('resource')),
        ]);
    }
}
