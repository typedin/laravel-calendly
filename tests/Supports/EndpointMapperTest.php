<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class EndpointMapperTest extends TestCase
{
    private function yaml(): string|bool
    {
        return file_get_contents(__DIR__.'/../../doc/openapi.yaml');
    }

    /**
     * @test
     */
    public function it_creates_entity_names(): void
    {
        $this->assertCount(44, (new EndpointMapper($this->yaml()))->entityNames());
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
    public function it_creates_controller_providers(): void
    {
        $output = (new EndpointMapper($this->yaml()))->controllerGeneratorProviders();
        $this->assertCount(28, $output);

        $provider = $output->firstWhere(function (ControllerGeneratorProvider $contoller_provider) {
            return $contoller_provider->controller_name == 'ScheduledEventInvitees';
        });

        $this->assertCount(2, $provider->paths);
        $this->assertArrayHasKey('/scheduled_events/{uuid}/invitees', $provider->paths->all());
        $this->assertArrayHasKey('/scheduled_events/{event_uuid}/invitees/{invitee_uuid}', $provider->paths->all());
    }

    /**
     * @test
     */
    public function it_maps_to_error_response_providers(): void
    {
        $output = (new EndpointMapper($this->yaml()))->errorResponseProviders();
        $this->assertCount(7, $output);
    }

    /**
     * @test
     */
    public function it_creates_form_request_provider(): void
    {
        $output = (new EndpointMapper($this->yaml()))->formRequestProviders();
        $this->assertCount(34, $output);
    }
}
