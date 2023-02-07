<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\Http\Requests\ShowUserRequest;

class CalendlyUsersController extends \Illuminate\Routing\Controller
{
    private \Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowUserRequest $request): JsonResponse
    {
        $response = $this->api->get("/users/{$request->validated('uuid')}/", $request);
        if (! $response->ok()) {
            return \Typedin\Services\ErrorResponseFactory::getJson($response);
        }

        return response()->json([
            'user' => new \Typedin\LaravelCalendly\Models\User(...$response->json('resource')),
        ]);
    }
}
