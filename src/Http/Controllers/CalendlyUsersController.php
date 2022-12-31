<?php

namespace Typedin\LaravelCalendly\Http\Controllers\CalendlyUsersController;

class CalendlyUsersController extends Illuminate\Routing\Controller
{
    public function __construct(Typedin\LaravelCalendly\Contracts\CalendlyApiInterface $api)
    {
        $this->api = $api;
    }

    public function show(\Typedin\LaravelCalendly\Http\GetUserRequest $request)
    {
        $response = $this->api->get("/users/{$uuid}/", $request);

        return response()->json([
            'user' => new \Typedin\LaravelCalendly\Entities\User($response),
        ]);
    }
}
