<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Nette\PhpGenerator\ClassType;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Http\Requests\IndexEventTypesRequest;
use Typedin\LaravelCalendly\Http\Requests\ShowInviteeNoShowRequest;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;
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
        $provider = new ControllerGeneratorProvider(
            name:'Users',
            endpoints: $this->endpoints('Users')
        );
        $controller = ControllerGenerator::controller($provider);

        $this->assertEquals('\Illuminate\Routing\Controller', $controller->getExtends());
        $this->assertEquals('CalendlyUsersController', $controller->getName());
    }

    /**
     * @test
     */
    public function it_generates_constructor(): void
    {
        $provider = new ControllerGeneratorProvider(
            name:'Users',
            endpoints: $this->endpoints('Users')
        );
        $controller = ControllerGenerator::controller($provider);

        $constructor = $controller->getMethod('__construct');

        $this->assertStringContainsString('$this->api = $api;', $constructor);
    }

    /**
     * @test
     */
    public function it_generates_index_method(): void
    {
        $provider = new ControllerGeneratorProvider(
            name:'EventTypes',
            endpoints: $this->endpoints('EventTypes')
        );
        $controller = ControllerGenerator::controller($provider);

        $method = $controller->getMethod('index');

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
        $provider = new ControllerGeneratorProvider(
            name:'InviteeNoShows',
            endpoints: $this->endpoints('InviteeNoShows')
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('show');

        $this->assertEquals(ShowInviteeNoShowRequest::class, $method->getParameters()['request']->getType());

        $this->assertStringContainsString('$response = $this->api->get("/invitee_no_shows/{$request->safe()->only(["uuid"])}/", $request);', $method->getBody());
        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"invitee_no_show" => new \Typedin\LaravelCalendly\Entities\CalendlyInviteeNoShow($response),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_create_method(): void
    {
        $provider = new ControllerGeneratorProvider(
            name:'SchedulingLinks',
            endpoints: $this->endpoints('SchedulingLinks')
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('create');

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
        $provider = new ControllerGeneratorProvider(
            name:'OrganizationInvitations',
            endpoints: $this->endpoints('OrganizationInvitations')
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('create');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->post("/organizations/{$request->safe()->only(["uuid"])}/invitations/", $request);', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"organization_invitation" => new \Typedin\LaravelCalendly\Entities\CalendlyOrganizationInvitation($response),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method(): void
    {
        $provider = new ControllerGeneratorProvider(
            name:'InviteeNoShows',
            endpoints: $this->endpoints('InviteeNoShows')
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('destroy');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\Requests\DestroyInviteeNoShowRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/invitee_no_shows/{$request->safe()->only(["uuid"])}/");', $method->getBody());

        $this->assertStringContainsString('return response()->noContent();', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method_with_many_uuids(): void
    {
        $provider = new ControllerGeneratorProvider(
            name:'OrganizationInvitations',
            endpoints: $this->endpoints('OrganizationInvitations')
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('destroy');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/organizations/{$request->safe()->only(["org_uuid"])}/invitations/{$request->safe()->only(["uuid"])}/");', $method->getBody());

        $this->assertStringContainsString('return response()->noContent();', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_all_methods_with_json_return_type(): void
    {
        $provider = new ControllerGeneratorProvider(
            name:'OrganizationInvitations',
            endpoints: $this->endpoints('OrganizationInvitations')
        );
        $controller = ControllerGenerator::controller($provider);
        $rest_methods = collect($controller->getMethods())
                ->filter(fn ($method) => in_array($method->getName(), ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']));

        // this includes the constructor
        $this->assertCount(3, $rest_methods);

        tap($rest_methods->each(function ($method) {
            $this->assertEquals('\Illuminate\Http\JsonResponse', $method->getReturnType());
        }));
    }

    /**
     * @test
     */
    public function it_works_for_every_key(): void
    {
        $content = file_get_contents(__DIR__.'/../__fixtures__/api.json');

        $keys = collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths'])
                    ->keys()
                    ->map(fn ($key) => EndpointMapper::fullname($key))
                    ->filter(fn ($value) => (bool) $value)
                    ->unique()
                    ->values();

        $keys->each(function ($key) {
            $provider = new ControllerGeneratorProvider(
                name: $key,
                endpoints: $this->endpoints($key)
            );
            $controller = ControllerGenerator::controller($provider);
            $this->assertInstanceOf(ClassType::class, $controller);
        });
    }
}
