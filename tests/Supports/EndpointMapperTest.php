<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class EndpointMapperTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/scheduled_events.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR))->all();
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
    public function endpointProvider(): array
    {
        return [
            ['DataComplianceInvitee', '/data_compliance/deletion/invitee'],
            ['EventTypes', '/event_types'],
            ['InviteeNoShows', '/invitee_no_shows/{uuid}'],
            ['OrganizationsInvitations', '/organizations/{org_uuid}/invitations/{uuid}'],
            ['ScheduledEvents', '/scheduled_events'],
            ['ScheduledEventsInvitees', '/scheduled_events/{event_uuid}/invitees/{invitee_uuid}'],
            ['ScheduledEventsInvitees', '/scheduled_events/{uuid}/invitees'],
            ['Users', '/users/me'],
            ['Users', '/users/{uuid}'],
            ['WebhookSubscriptions', '/webhook_subscriptions/{webhook_uuid}'],
        ];
    }

    /**
     * @test
     */
    public function it_maps_endpoints_to_controller_name(): void
    {
        $this->assertCount(5, EndpointMapper::toControllerName($this->data()));

        $this->assertEquals(EndpointMapper::toControllerName($this->data())['/scheduled_events/{uuid}/invitees'], 'ScheduledEventsInvitees');
        $this->assertEquals(EndpointMapper::toControllerName($this->data())['/scheduled_events'], 'ScheduledEvents');
        $this->assertEquals(EndpointMapper::toControllerName($this->data())['/scheduled_events'], 'ScheduledEvents');
        /**
         * the api post to cancellation
         * so it "creates" a cancellation
         */
        $this->assertEquals(EndpointMapper::toControllerName($this->data())['/scheduled_events/{uuid}/cancellation'], 'ScheduledEventsCancellation');
    }
}
