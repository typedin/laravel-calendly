<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class EndpointMapperTest extends TestCase
{
    private function yaml(): string|bool
    {
        return file_get_contents(__DIR__.'/../../doc/openapi.yaml');
    }

    /**
     * @dataProvider endpointProvider
     *
     * @test
     */
    public function it_creates_cruddy_controller_names_for_endpoints($result, $input): void
    {
        $this->assertEquals($result, EndpointMapper::fullname($input));
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function endpointProvider(): array
    {
        $content = collect(json_decode(file_get_contents(__DIR__.'/__fixtures__/Endpoints.json'), null, 512, JSON_THROW_ON_ERROR));

        return $content
            ->values()
            ->flatMap(fn ($value) => collect($value->endpoints)->map(
                fn ($endpoint) => [$value->name, $endpoint]
            ))
            ->all();
    }

    /**
     * @test
     */
    public function it_creates_entity_names(): void
    {
        $this->assertCount(45, (new EndpointMapper($this->yaml()))->entityNames());
    }

    /**
     * @test
     */
    public function it_creates_controller_names(): void
    {
        $things = [
            'ScheduledEvents',
            'ScheduledEventInvitees',
            'ScheduledEventCancellations',
        ];

        $this->assertCount(17, (new EndpointMapper($this->yaml()))->controllerNames());
        $this->assertContains($things[0], (new EndpointMapper($this->yaml()))->controllerNames());
        $this->assertContains($things[1], (new EndpointMapper($this->yaml()))->controllerNames());
        $this->assertContains($things[2], (new EndpointMapper($this->yaml()))->controllerNames());
    }

    /**
     * @test
     */
    public function it_creates_form_request_dto(): void
    {
        $filtered = (new EndpointMapper($this->yaml()))->formRequestDTOS()->filter(fn ($value) => $value['name'] == 'OrganizationInvitations');
        $filtered->each(function ($value) {
            /* dd($value['/organizations/{uuid}/invitations']); */
            $this->assertEquals('OrganizationInvitations', $value['name']);
        });
    }

    /**
     * @test
     */
    public function it_maps_controller_names_to_endpoints(): void
    {
        $output = (new EndpointMapper($this->yaml()))->mapControllerNamesToEndpoints();

        $this->assertArrayHasKey('/scheduled_events', $output->get('ScheduledEvents'));
        $this->assertArrayHasKey('get', $output->get('ScheduledEvents')['/scheduled_events']);
    }
}
