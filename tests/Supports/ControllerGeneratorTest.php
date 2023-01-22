<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Illuminate\Http\JsonResponse;
use Nette\PhpGenerator\ClassType;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Http\Requests\DestroyInviteeNoShowRequest;
use Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowInviteeNoShowRequest;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function endpoints(mixed $filter): array
    {
        $mapper = new EndpointMapper(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));

        return $mapper->mapControllerNamesToEndpoints()->get($filter)->all();
    }

    /**
     * @test
     */
    public function it_generates_controller_name(): void
    {
        $generated_class = ( new ControllerGenerator('Users', $this->endpoints('Users')) )->controller;

        $this->assertEquals('CalendlyUsersController', $generated_class->getName());
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

        $this->assertEquals(IndexEventTypesRequest::class, $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->get("/event_types/", $request);', $method->getBody());
        $this->assertStringContainsString('$all = collect($response["collection"])', $method->getBody());
        $this->assertStringContainsString('->mapInto(\Typedin\LaravelCalendly\Entities\CalendlyEventType::class)->all();', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"event_types" => $all,', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());

        // TODO pagination
    }

    /**
     * @test
     */
    public function it_generates_show_method(): void
    {
        $method = ( new ControllerGenerator('InviteeNoShows', $this->endpoints('InviteeNoShows')) )->controller->getMethod('show');

        $this->assertEquals(ShowInviteeNoShowRequest::class, $method->getParameters()['request']->getType());

        $this->assertStringContainsString('$response = $this->api->get("/invitee_no_shows/{$uuid}/", $request);', $method->getBody());
        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"invitee_no_show" => new \Typedin\LaravelCalendly\Entities\CalendlyInviteeNoShow($response),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_create_method(): void
    {
        $method = ( new ControllerGenerator('SchedulingLinks', $this->endpoints('SchedulingLinks')) )->controller->getMethod('create');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\Requests\StoreSchedulingLinkRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->post("/scheduling_links/", $request);', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"scheduling_link" => new \Typedin\LaravelCalendly\Entities\CalendlySchedulingLink($response),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_create_method_with_uuid(): void
    {
        $method = ( new ControllerGenerator('OrganizationInvitations', $this->endpoints('OrganizationInvitations')) )->controller->getMethod('create');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->post("/organizations/{$uuid}/invitations/", $request);', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"organization_invitation" => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method(): void
    {
        $method = ( new ControllerGenerator('InviteeNoShows', $this->endpoints('InviteeNoShows')) )->controller->getMethods()['destroy'];

        $this->assertEquals('\\'.DestroyInviteeNoShowRequest::class, $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/invitee_no_shows/{$uuid}/");', $method->getBody());

        $this->assertStringContainsString('return response()->noContent();', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method_with_many_uuids(): void
    {
        $method = ( new ControllerGenerator('OrganizationInvitations', $this->endpoints('OrganizationInvitations')) )->controller->getMethods()['destroy'];

        $this->assertEquals('\\'.DestroyOrganizationInvitationRequest::class, $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/organizations/{$org_uuid}/invitations/{$uuid}/");', $method->getBody());

        $this->assertStringContainsString('return response()->noContent();', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_all_methods_with_json_return_type(): void
    {
        $rest_methods = collect(( new ControllerGenerator('OrganizationInvitations', $this->endpoints('OrganizationInvitations')) )->controller->getMethods())
                ->filter(fn ($method) => in_array($method->getName(), ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']));

        // this includes the constructor
        $this->assertCount(3, $rest_methods);

        tap($rest_methods->each(function ($method) {
            $this->assertEquals(JsonResponse::class, $method->getReturnType());
        }));
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
            $this->assertInstanceOf(ClassType::class, $controller);
        });
    }
}
