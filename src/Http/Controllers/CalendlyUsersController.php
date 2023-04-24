<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowUserRequest;
use Typedin\LaravelCalendly\Models\User;
use Typedin\LaravelCalendly\Services\ErrorResponseFactory;

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
        if (! $response->ok()) {
        return ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'user' => new User(...$response->json('resource')),
        ]);
    }
}
