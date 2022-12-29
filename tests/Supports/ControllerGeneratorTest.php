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

        return $local->filter(fn ($_value, $key) => $filter == EndpointMapper::fullname($key))->all();
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
        $this->assertStringContainsString('$response = $this->api->get("/event_types/");', $method->getBody());
        $this->assertStringContainsString('$all = collect($response["collection"])', $method->getBody());
        $this->assertStringContainsString('->mapInto(EventType::class)->all();', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"event_types" => $all,', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());

        // collection: EnventType
        // pagination
    }

    /**
     * @test
     */
    public function it_generates_show_method(): void
    {
        $method = ( new ControllerGenerator('Users', $this->endpoints('Users')) )->controller->getMethod('show');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\GetUserRequest', $method->getParameters()['request']->getType());

        $this->assertEquals('\Typedin\LaravelCalendly\Http\GetUserRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->get("/users/{$uuid}/");', $method->getBody());
        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"user" => new \Typedin\LaravelCalendly\Entities\User($response),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
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
    public function it_generates_post_method_with_uuid(): void
    {
        $method = ( new ControllerGenerator('OrganizationInvitations', $this->endpoints('OrganizationInvitations')) )->controller->getMethod('post');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\PostOrganizationInvitationRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->post("/organizations/{$uuid}/invitations/");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method(): void
    {
        $method = ( new ControllerGenerator('InviteeNoShows', $this->endpoints('InviteeNoShows')) )->controller->getMethods()['destroy'];

        $this->assertEquals('\Typedin\LaravelCalendly\Http\DeleteInviteeNoShowRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/invitee_no_shows/{$uuid}/");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method_with_many_uuids(): void
    {
        $method = ( new ControllerGenerator('OrganizationInvitations', $this->endpoints('OrganizationInvitations')) )->controller->getMethods()['destroy'];

        $this->assertEquals('\Typedin\LaravelCalendly\Http\DeleteOrganizationInvitationRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_all_methods(): void
    {
        $controller = ( new ControllerGenerator('InviteeNoShows', $this->endpoints('InviteeNoShows')) )->controller;

        $this->assertCount(4, $controller->getMethods());
    }

    /**
     * @test
     */
    public function it_works_for_every_key(): void
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        $keys = collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths'])
                    ->keys()
                    ->map(fn ($key) => EndpointMapper::fullname($key))
                    ->filter(fn ($value) => (bool) $value)
                    ->unique()
                    ->values();

        $keys->each(function ($key) {
            $controller = ( new ControllerGenerator($key, $this->endpoints($key)) )->controller;
            $this->assertInstanceOf(\Nette\PhpGenerator\ClassType::class, $controller);
        });
    }
}
