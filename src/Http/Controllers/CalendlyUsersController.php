<?php

namespace Typedin\LaravelCalendly\Http\Controllers;

use CalendlyApiInterface;
use Controller;
use JsonResponse;
use ShowUserRequest;
use Typedin\LaravelCalendly\Entities\CalendlyUser;

class CalendlyUsersController extends Controller
{
    private readonly CalendlyApiInterface $api;

    public function __construct(CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(ShowUserRequest $request): JsonResponse
    {
        $response = $this->api->get("/users/{$request->safe()->only(['uuid'])}/", $request);

        return response()->json([
            'user' => new CalendlyUser($response),
        ]);
    }
}
