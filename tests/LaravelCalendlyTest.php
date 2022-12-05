<?php

namespace Typedin\LaravelCalendly\Tests;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use Typedin\LaravelCalendly\CalendlyService;
use Typedin\LaravelCalendly\CalendlyUser;
use Typedin\LaravelCalendly\LaravelCalendly;
use Typedin\LaravelCalendly\Organization\CalendlyOrganization;

class LaravelCalendlyTest extends TestCase
{
    /**
     * @var mixed|Repository
     */
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();

        $this->token = 'a_test_token';
    }

    /**
     * @test
     */
    public function it_can_get_current_user(): void
    {
        Http::fake([
            'https://api.calendly.com/users/me' => Http::response($this->fixture('current-user'), 200),
        ]);

        $me = (new LaravelCalendly($this->token))->getCurrentUser();

        $this->assertEquals($me->name, 'John Doe');
        $this->assertEquals($me->uuid, 'fake-user-uuid');
        $this->assertEquals($me->created_at->toDateString(), '2019-01-02');
        $this->assertEquals($me->uri, 'https://api.calendly.com/users/fake-user-uuid');
    }

    /**
     * @test
     */
    public function it_can_get_a_user(): void
    {
        Http::fake([
            'https://api.calendly.com/users/a-user-uuid' => Http::response($this->fixture('a-user'), 200),
        ]);

        $calendly_user = (new CalendlyService($this->token))->getUser('a-user-uuid');

        $this->assertEquals($calendly_user->name, 'John Doe');
        $this->assertEquals($calendly_user->uuid, 'a-user-uuid');
        $this->assertEquals($calendly_user->created_at->toDateString(), '2019-01-02');
        $this->assertEquals($calendly_user->uri, 'https://api.calendly.com/users/a-user-uuid');
    }

    /**
     * @test
     */
    public function it_can_get_organization(): void
    {
        Http::fake([
            'https://api.calendly.com/organizations/fake-current-organization-uuid' => Http::response($this->fixture('organization', '/../Calendly/Organization/'), 200),
        ]);

        $calendly_organization = (new CalendlyService($this->token))
            ->getOrganization(new CalendlyUser($this->fixture('current-user')['resource']));

        $this->assertEquals($calendly_organization->stage, 'trial');
        $this->assertEquals($calendly_organization->plan, 'basic');
        $this->assertEquals($calendly_organization->uri, 'https://api.calendly.com/organizations/fake-organization-uuid');
    }

    /**
     * @test
     */
    public function it_lists_user_event_for_organization(): void
    {
        Http::fake([
            'https://api.calendly.com/scheduled_events*' => Http::response($this->fixture('scheduled-events', '/./ScheduledEvent/'), 200),
        ]);

        $events = (new CalendlyService($this->token))
            ->getUserEventsForOrganization(
                new CalendlyUser($this->fixture('current-user')['resource']),
                new CalendlyOrganization($this->fixture('organization', '/./Organization/')['resource'])
            );

        $this->assertCount(1, $events);
    }

    private function fixture(string $filename, string $path = ''): mixed
    {
        return json_decode(
            file_get_contents(__DIR__ . $path . '/__fixtures__/' . $filename . '.json'),
            true
        );
    }
}
