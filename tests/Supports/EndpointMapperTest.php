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
     * @test
     */
    public function it_creates_cruddy_controller_names_for_endpoints($result, $input): void
    {
        $this->assertEquals($result, EndpointMapper::fullname($input));
    }

    /**
     * @return array<int,array<int,string>>
     */
    public function endpointProvider()
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/Endpoints.json');

        return collect(json_decode($content))
            ->values()
            ->flatMap(function ($value) {
                return collect($value->endpoints)->map(function ($endpoint) use ($value) {
                    return [$value->name, $endpoint];
                });
            })->all();

        return [
            ['DataComplianceInvitees', '/data_compliance/deletion/invitee'],
            ['EventTypes', '/event_types'],
            ['InviteeNoShows', '/invitee_no_shows/{uuid}'],
            ['OrganizationInvitations', '/organizations/{org_uuid}/invitations/{uuid}'],
            ['ScheduledEventInvitees', '/scheduled_events/{event_uuid}/invitees/{invitee_uuid}'],
            ['ScheduledEventInvitees', '/scheduled_events/{uuid}/invitees'],
            ['ScheduledEvents', '/scheduled_events'],
            ['Users', '/users/me'],
            ['Users', '/users/{uuid}'],
            ['WebhookSubscriptions', '/webhook_subscriptions/{webhook_uuid}'],
        ];
    }

    /**
     * @test
     */
    public function it_creates_entity_names_(): void
    {
        $this->assertCount(45, (new EndpointMapper($this->yaml()))->entityNames());
    }

    /**
     * @test
     */
    public function it_creates_controller_names_(): void
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
    public function it_maps_controller_names_to_endpoints(): void
    {
        $output = (new EndpointMapper($this->yaml()))->mapControllerNamesToEndpoints();

        $this->assertArrayHasKey('/scheduled_events', $output->get('ScheduledEvents'));
        $this->assertArrayHasKey('get', $output->get('ScheduledEvents')['/scheduled_events']);
    }
}
