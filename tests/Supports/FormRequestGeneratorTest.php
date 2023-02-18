<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Illuminate\Foundation\Http\FormRequest;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\Configuration\DestroyFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\IndexFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ShowFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\StoreFormRequestProvider;
use Typedin\LaravelCalendly\Supports\EndpointMapper;
use Typedin\LaravelCalendly\Supports\FormRequestGenerator;

class FormRequestGeneratorTest extends TestCase
{
    private EndpointMapper $mapper;

    /* private array $json; */

    protected function setUp(): void
    {
        $this->mapper = new EndpointMapper(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
    }

    private function path(string $filter): array
    {
        return $this->mapper->paths()->get($filter);
    }

    /**
     * @dataProvider ScheduledEventsProvider
     *
     * @test
     *
     * @param  string  $property
     * @param  string  $expected_rules
     */
    public function it_generates_rules_for_index_form_request($property, $expected_rules): void
    {
        $provider = new IndexFormRequestProvider(
            path: '/scheduled_events',
            name:'ScheduledEvents',
            value: $this->path('/scheduled_events')
        );

        $validator = FormRequestGenerator::formRequest($provider);

        $this->assertEquals('IndexScheduledEventsRequest', $validator->getName());
        $this->assertEquals('\\'.FormRequest::class, $validator->getExtends());

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $validator->getMethod('rules')->getBody());
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function ScheduledEventsProvider(): array
    {
        return [
            ['user', 'url'],
            ['organization', 'url'],
            ['invitee_email', 'email'],
            ['status', 'in:active,canceled'],
            ['sort', 'string'],
            ['max_start_time', 'date'],
            ['min_start_time', 'date'],
        ];
    }

    /**
     * @dataProvider EventTypesProvider
     *
     * @test
     */
    public function it_generates_rules_for_event_types(mixed $property, mixed $expected_rules): void
    {
        $provider = new IndexFormRequestProvider(path: '/event_types', name:'EventTypes', value: $this->path('/event_types'));
        $validator = FormRequestGenerator::formRequest($provider);

        $this->assertEquals('\\'.FormRequest::class, $validator->getExtends());
        $this->assertEquals('IndexEventTypesRequest', $validator->getName());

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $validator->getMethod('rules')->getBody());
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function EventTypesProvider(): array
    {
        return [
            ['active', 'boolean'],
            ['organization', 'url'],
            ['user', 'url'],
            ['sort', 'string'],
        ];
    }

    /**
     * @dataProvider ScheduledEventInviteesProvider
     *
     * @test
     */
    public function it_generates_show_form_request(mixed $property, mixed $expected_rules): void
    {
        $provider = new ShowFormRequestProvider(
            path: '/scheduled_events/{event_uuid}/invitees/{invitee_uuid}',
            name: 'ScheduledEvents',
            value: $this->path('/scheduled_events/{event_uuid}/invitees/{invitee_uuid}')
        );

        $validator = FormRequestGenerator::formRequest($provider);

        $this->assertEquals('\\'.FormRequest::class, $validator->getExtends());
        $this->assertEquals('ShowScheduledEventRequest', $validator->getName());
        $rules = $validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function ScheduledEventInviteesProvider(): array
    {
        return [
            ['event_uuid', 'required|string'],
            ['invitee_uuid', 'required|string'],
        ];
    }

    /**
     * @dataProvider userProvider
     *
     * @test
     */
    public function it_generates_show_form_request_for_user(mixed $property, mixed $expected_rules): void
    {
        $provider = new ShowFormRequestProvider(
            path: '/users/{uuid}',
            name: 'Users',
            value: $this->path('/users/{uuid}')
        );

        $validator = FormRequestGenerator::formRequest($provider);

        $this->assertEquals('\\'.FormRequest::class, $validator->getExtends());
        $this->assertEquals('ShowUserRequest', $validator->getName());
        $rules = $validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function userProvider(): array
    {
        return [
            ['uuid', 'required|string'],
        ];
    }

    /**
     * @test
     */
    public function it_generates_store_form_request_from_post_path(): void
    {
        $provider = new StoreFormRequestProvider(path: '/organizations/{uuid}/invitations', name: 'OrganizationInviations', value: $this->path('/organizations/{uuid}/invitations'));

        $validator = FormRequestGenerator::formRequest($provider);

        $this->assertEquals('\\'.FormRequest::class, $validator->getExtends());

        $this->assertEquals('StoreOrganizationInviationRequest', $validator->getName());
        $rules = $validator->getMethod('rules');

        $this->assertStringContainsString("'uuid' => 'required|string", $rules);
        $this->assertStringContainsString("'email' => 'required|email", $rules);
    }

    /**
     * @dataProvider DestroyOrganizationMembershipRequestsProvider
     *
     * @test
     */
    public function it_generates_destroy_form_request(mixed $property, mixed $expected_rules): void
    {
        $provider = new DestroyFormRequestProvider(
            path: '/organization_memberships/{uuid}',
            name: 'OrganizationMemberships',
            value: $this->path('/organization_memberships/{uuid}')
        );
        $validator = FormRequestGenerator::formRequest($provider);

        $this->assertEquals('\\'.FormRequest::class, $validator->getExtends());

        $this->assertEquals('DestroyOrganizationMembershipRequest', $validator->getName());
        $rules = $validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function DestroyOrganizationMembershipRequestsProvider(): array
    {
        return [
            ['uuid', 'required|string'],
        ];
    }
}
