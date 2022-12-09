<?php

namespace Typedin\LaravelCalendly\Repository;

use Facades\Typedin\LaravelCalendly\Api\BaseApiClient;
use Typedin\LaravelCalendly\CalendlyUser;

class UserRepository
{
    public static function me(): CalendlyUser
    {
        $response = BaseApiClient::get("users/me");

        return new CalendlyUser($response->json("resource"), "users");
    }
}
