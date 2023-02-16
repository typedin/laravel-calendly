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
    public function it_creates_form_request_provider(): void
    {
        $output = (new EndpointMapper($this->yaml()))->formRequestProviders();
        $this->assertCount(34, $output);
    }

    /**
     * @dataProvider allPaths
     *
     * @test
     */
    public function it_maps_controller_names_to_endpoints($controller_name, $paths): void
    {
        $output = (new EndpointMapper($this->yaml()))->mapControllerNamesToEndpoints();

        collect($paths)->each(function ($value) use ($output, $controller_name) {
            $this->assertArrayHasKey($value, $output->get($controller_name));
        });
    }

    public function allPaths()
    {
        return [

            [
                'ActivityLogEntries', [
                    '/activity_log_entries',
                ],
            ],

            [
                'DataComplianceDeletionInvitees', [
                    '/data_compliance/deletion/invitees',
                ],
            ],

            [
                'EventTypeAvailableTimes', [
                    '/event_type_available_times',
                ],
            ],

            [
                'EventTypes', [
                    '/event_types',
                    '/event_types/{uuid}',
                ],
            ],

            [
                'InviteeNoShows', [
                    '/invitee_no_shows',
                    '/invitee_no_shows/{uuid}',
                ],
            ],

            [
                'OrganizationMemberships', [
                    '/organization_memberships',
                    '/organization_memberships/{uuid}',
                ],
            ],

            [
                'OrganizationInvitations', [
                    '/organizations/{org_uuid}/invitations/{uuid}',
                    '/organizations/{uuid}/invitations',
                ],
            ],

            [
                'RoutingFormSubmissions', [
                    '/routing_form_submissions',
                    '/routing_form_submissions/{uuid}',
                ],
            ],
            [
                'RoutingForms', [
                    '/routing_forms',
                    '/routing_forms/{uuid}',
                ],
            ],

            [
                'ScheduledEvents', [
                    '/scheduled_events',
                    '/scheduled_events/{uuid}',
                ],
            ],

            [
                'ScheduledEventCancellations', [
                    '/scheduled_events/{uuid}/cancellation',
                ],
            ],

            [
                'ScheduledEventInvitees', [
                    '/scheduled_events/{uuid}/invitees',
                    '/scheduled_events/{event_uuid}/invitees/{invitee_uuid}',
                ],
            ],

            [
                'SchedulingLinks', [
                    '/scheduling_links',
                ],
            ],

            [
                'UserAvailabilitySchedules', [
                    '/user_availability_schedules',
                    '/user_availability_schedules/{uuid}',
                ],
            ],

            [
                'UserBusyTimes', [
                    '/user_busy_times',
                ],
            ],

            [
                'Users', [
                    '/users/me',
                    '/users/{uuid}',
                ],
            ],

            [
                'WebhookSubscriptions', [
                    '/webhook_subscriptions',
                    '/webhook_subscriptions/{webhook_uuid}',
                ],
            ],
        ];
    }

    /**
     * @test
     */
    public function it_maps_to_error_response_providers(): void
    {
        $output = (new EndpointMapper($this->yaml()))->errorResponseProviders();
        $this->assertCount(7, $output);
    }
}
