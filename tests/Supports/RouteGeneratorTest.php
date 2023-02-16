<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\EndpointMapper;
use Typedin\LaravelCalendly\Supports\RouteGenerator;

class RouteGeneratorTest extends TestCase
{
    private EndpointMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new EndpointMapper(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
    }

    /** @test */
    public function it_generates_a_route_for_a_single_show_method(): void
    {
        $path = '/users/{uuid}';

        $this->assertEquals('Route::get("/user", [\Typedin\LaravelCalendly\Http\Controllers\CalendlyUsersController::class, "show"])', RouteGenerator::fromPath($this->mapper, $path)[0]);
    }

    /** @test */
    public function it_generates_two_routes_for_get_and_destroy(): void
    {
        $path = '/organizations/{org_uuid}/invitations/{uuid}';

        $this->assertEquals('Route::delete("/organization/invitation", [\Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController::class, "destroy"])', RouteGenerator::fromPath($this->mapper, $path)[0]);
        $this->assertEquals('Route::get("/organization/invitation", [\Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController::class, "show"])', RouteGenerator::fromPath($this->mapper, $path)[1]);
    }

    /** @test */
    public function it_generates_index_method(): void
    {
        $path = '/organizations/{uuid}/invitations';

        $this->assertEquals('Route::post("/organization/invitation", [\Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController::class, "create"])', RouteGenerator::fromPath($this->mapper, $path)[1]);
        $this->assertEquals('Route::get("/organization/invitations", [\Typedin\LaravelCalendly\Http\Controllers\CalendlyOrganizationInvitationsController::class, "index"])', RouteGenerator::fromPath($this->mapper, $path)[0]);
    }

    /** @test */
    public function it_throws_exceptions_when_path_is_not_found(): void
    {
        $path = '/not/a/path';
        $this->expectExceptionMessage('The path ( /not/a/path ) was not found.');

        RouteGenerator::fromPath($this->mapper, $path);
    }
}
