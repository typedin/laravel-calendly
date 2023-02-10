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

    /** @test */
    public function it_generate_a_route_for_a_single_method()
    {
        $path = '/users/{uuid}';

        $this->assertContains('Route::get("/users/{uuid}", [CalendlyUsersController::class, "show"])', RouteGenerator::fromPath($this->mapper, $path));
    }
}
