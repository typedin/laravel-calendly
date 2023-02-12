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
        parent::setUp();
        $this->mapper = new EndpointMapper(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
    }

    /**
     * @return array<TKey,TValue>
     */
    private function endpoints(mixed $filter): array
    {
        return $this->mapper->mapControllerNamesToEndpoints()->get($filter)->all();
    }

    /** @test */
    public function it_generates_a_route_for_a_single_show_method()
    {
        $path = '/users/{uuid}';

        $this->assertContains('Route::get("/users/{uuid}", [CalendlyUsersController::class, "show"])', RouteGenerator::fromPath($this->mapper, $path));
    }

    /** @test */
    public function it_generates_two_routes_for_get_and_destroy()
    {
        $path = '/organizations/{org_uuid}/invitations/{uuid}';

        $this->assertContains('Route::get("/organizations/{org_uuid}/invitations/{uuid}", [CalendlyOrganizationInvitationsController::class, "show"])', RouteGenerator::fromPath($this->mapper, $path));
        $this->assertContains('Route::delete("/organizations/{org_uuid}/invitations/{uuid}", [CalendlyOrganizationInvitationsController::class, "destroy"])', RouteGenerator::fromPath($this->mapper, $path));
    }

    /** @test */
    public function it_generates_index_method()
    {
        $path = '/organizations/{uuid}/invitations';

        $this->assertContains('Route::get("/organizations/{uuid}/invitations", [CalendlyOrganizationInvitationsController::class, "index"])', RouteGenerator::fromPath($this->mapper, $path));
        $this->assertContains('Route::post("/organizations/{uuid}/invitations", [CalendlyOrganizationInvitationsController::class, "create"])', RouteGenerator::fromPath($this->mapper, $path));
    }

    /** @test */
    public function it_throws_exceptions()
    {
        $this->expectExceptionMessage('Could not determine a method for the path:');
        $path = '/not/a/route';

        RouteGenerator::fromPath($this->mapper, $path);
    }
}
