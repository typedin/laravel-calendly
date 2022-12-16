<?php

namespace Typedin\LaravelCalendly\Tests\Entities\ScheduledEvent;

use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyEventMembership;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyEventMembershipTest extends CalendlyTestCase
{
    private $user = [
        "uri" => "https://api.calendly.com/users/a-user-uuid",
        "name" => "John Doe",
        "slug" => "acmesales",
        "email" => "test@example.com",
        "scheduling_url" => "https://calendly.com/acmesales",
        "timezone" => "America/New York",
        "avatar_url" => "https://01234567890.cloudfront.net/uploads/user/avatar/0123456/a1b2c3d4.png",
        "created_at" => "2019-01-02T03:04:05.678123Z",
        "updated_at" => "2019-08-07T06:05:04.321123Z",
        "current_organization" => "https://api.calendly.com/organizations/AAAAAAAAAAAAAAAA",
    ];

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $event_membership = new CalendlyEventMembership($this->user);


        $this->assertInstanceOf(CalendlyUser::class, $event_membership);
    }
}
