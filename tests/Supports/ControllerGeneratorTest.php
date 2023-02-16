<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Nette\PhpGenerator\ClassType;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorTest extends TestCase
{
    private EndpointMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new EndpointMapper(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
    }

    /**
     * @test
     */
    public function it_generates_controller_name(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path: '/users/{uuid}'
        );
        $controller = ControllerGenerator::controller($provider);

        $this->assertEquals('\\'.Controller::class, $controller->getExtends());
        $this->assertEquals('CalendlyUsersController', $controller->getName());
    }

    /**
     * @test
     */
    public function it_generates_constructor(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path: '/users/{uuid}'
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
            mapper: $this->mapper,
            path:   '/event_types'
        );
        $controller = ControllerGenerator::controller($provider);

        $method = $controller->getMethod('index');
        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\IndexEventTypesRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->get("/event_types/", $request);', $method->getBody());
        $this->assertStringContainsString('$all = collect($response->collect("collection"))', $method->getBody());
        $this->assertStringContainsString('->map(fn ($args) => new \Typedin\LaravelCalendly\Models\EventType(...$args));', $method->getBody());

        $this->assertStringContainsString('$pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect("pagination")->all());', $method->getBody());
        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"event_types" => $all,', $method->getBody());
        $this->assertStringContainsString('"pagination" => $pagination,', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_applesauce(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path: '/organizations/{uuid}/invitations'
        );
        $controller = ControllerGenerator::controller($provider);

        $controller->getMethod('index');
    }

    /**
     * @test
     */
    public function it_generates_show_method(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path:   '/invitee_no_shows/{uuid}'
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('show');

        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\ShowInviteeNoShowRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->get("/invitee_no_shows/{$request->validated("uuid")}/", $request);', $method->getBody());
        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"invitee_no_show" => new \Typedin\LaravelCalendly\Models\InviteeNoShow(...$response->json("resource")),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_create_method(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path: '/scheduling_links'
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('create');

        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\StoreSchedulingLinkRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->post("/scheduling_links/", $request);', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"booking_url" => new \Typedin\LaravelCalendly\Models\BookingUrl(...$response->json("resource")),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_create_method_for_202_response(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path: '/data_compliance/deletion/invitees'
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('create');

        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\StoreDataComplianceDeletionInviteeRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->post("/data_compliance/deletion/invitees/", $request);', $method->getBody());

        $this->assertStringContainsString('return \Illuminate\Support\Facades\Response::json([], 202);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_create_method_with_uuid(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path:   '/organizations/{uuid}/invitations'
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('create');

        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\StoreOrganizationInvitationRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->post("/organizations/{$request->validated("uuid")}/invitations/", $request);', $method->getBody());

        $this->assertStringContainsString('return response()->json([', $method->getBody());
        $this->assertStringContainsString('"organization_invitation" => new \Typedin\LaravelCalendly\Models\OrganizationInvitation(...$response->json("resource")),', $method->getBody());
        $this->assertStringContainsString(']);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path: '/invitee_no_shows/{uuid}'
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('destroy');

        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\DestroyInviteeNoShowRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$response = $this->api->delete("/invitee_no_shows/{$request->validated("uuid")}/");', $method->getBody());

        $this->assertStringContainsString('return \Illuminate\Support\Facades\Response::json([], 204);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_destroy_method_with_many_uuids(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path:   '/organizations/{org_uuid}/invitations/{uuid}'
        );
        $controller = ControllerGenerator::controller($provider);
        $method = $controller->getMethod('destroy');

        $this->assertEquals("\Typedin\LaravelCalendly\Http\Requests\DestroyOrganizationInvitationRequest", $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->delete("/organizations/{$request->validated("org_uuid")}/invitations/{$request->validated("uuid")}/");', $method->getBody());

        $this->assertStringContainsString('return \Illuminate\Support\Facades\Response::json([], 204);', $method->getBody());
        $this->assertStringContainsString('if(!$response->ok()) {', $method->getBody());
        $this->assertStringContainsString('}', $method->getBody());
    }

    /**
     * @test
     */
    public function it_generates_all_methods_with_json_return_type(): void
    {
        $provider = new ControllerGeneratorProvider(
            mapper: $this->mapper,
            path:   '/organizations/{uuid}/invitations'
        );
        $controller = ControllerGenerator::controller($provider);
        $rest_methods = collect($controller->getMethods())
        ->filter(
            fn ($method) => in_array($method->getName(), ['index', 'show', 'create', 'store', 'edit', 'update', 'destroy'])
        );

        $this->assertCount(2, $rest_methods);

        tap($rest_methods->each(function ($method) {
            $this->assertEquals('\\'.JsonResponse::class, $method->getReturnType());
        }));
    }

    /**
     * @test
     */
    public function it_works_for_all_keys(): void
    {
        $this->mapper->paths()
            ->keys()
            ->each(function ($key) {
                $provider = new ControllerGeneratorProvider(
                    mapper: $this->mapper,
                    path: $key
                );

                $this->assertInstanceOf(ClassType::class, ControllerGenerator::controller($provider));
            });
    }
}
