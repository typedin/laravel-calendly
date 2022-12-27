<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function endpoints($filter): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        $local = collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths']);

        return $local->filter(function ($value, $key) use ($filter) {
            return  $filter == EndpointMapper::fullname($key);
        })->all();
    }

    /**
     * @test
     */
    public function it_generates_controller_name_and_namespace(): void
    {
        $generated_class = ( new ControllerGenerator('Users', $this->endpoints('Users')) )->controller;

        $this->assertEquals('CalendlyUsersController', $generated_class->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Http\Controllers\CalendlyUsersController', $generated_class->getNamespace()->getName());
    }

    /**
     * @test
     */
    public function it_generates_constructor(): void
    {
        $constructor = ( new ControllerGenerator('Users', $this->endpoints('Users')) )->controller->getMethod('__construct');

        $this->assertStringContainsString('$this->api = $api;', $constructor);
    }

    /**
     * @test
     */
    public function it_generates_index_method(): void
    {
        $method = ( new ControllerGenerator('EventTypes', $this->endpoints('EventTypes')) )->controller->getMethod('index');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\IndexEventTypeRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->get("/event_types/{$uuid}");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_show_method(): void
    {
        $method = ( new ControllerGenerator('Users', $this->endpoints('Users')) )->controller->getMethod('show');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\GetUserRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->get("/users/{$uuid}");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_post_method(): void
    {
        $method = ( new ControllerGenerator('SchedulingLinks', $this->endpoints('SchedulingLinks')) )->controller->getMethod('post');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\PostSchedulingLinkRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->post("/scheduling_links/");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method(): void
    {
        $method = ( new ControllerGenerator('InviteeNoShows', $this->endpoints('InviteeNoShows')) )->controller->getMethods()['destroy'];

        $this->assertEquals('\Typedin\LaravelCalendly\Http\DeleteInviteeNoShowRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/invitee_no_shows/");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_all_methods(): void
    {
        $controller = ( new ControllerGenerator('InviteeNoShows', $this->endpoints('InviteeNoShows')) )->controller;

        $this->assertCount(4, $controller->getMethods());
    }
}
