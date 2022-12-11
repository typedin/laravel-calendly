<?php

namespace Typedin\LaravelCalendly\Tests\Api;

use Carbon\Carbon;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use Typedin\LaravelCalendly\Api\ScheduledEventsApiClient;
use Typedin\LaravelCalendly\Entities\Organization\CalendlyOrganization;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;
use Typedin\LaravelCalendly\Tests\fakes\OrganizationFake;
use Typedin\LaravelCalendly\Tests\fakes\UserFake;

class ScheduledEventsApiClientTest extends TestCase
{
    protected $loadEnvironmentVariables = true;

    private CalendlyUser $fakeUser;

    private CalendlyOrganization $fakeOrganization;

    protected function setUp(): void
    {
        parent::setUp();
        Http::fake();

        config()->set('calendly', [
            'api' => [
                'key' => 'a-fake-api-key',
                'endpoint' => 'api.calendly.com',
            ],
        ]);
        $user = new UserFake();
        $organization = new OrganizationFake();

        $this->fakeUser = $user();
        $this->fakeOrganization = $organization();
    }

    protected function getPackageProviders($app): array
    {
        return [
            "Typedin\LaravelCalendly\LaravelCalendlyServiceProvider",
        ];
    }

    /**
     * @test
     */
    public function it_can_list_schedules_events_for_an_organization_with_no_params(): void
    {
        ScheduledEventsApiClient::list($this->fakeUser, $this->fakeOrganization);

        Http::assertSent(function (Request $request) {
            return
                $request['user'] == $this->fakeUser->uri &&
                $request['organization'] == $this->fakeOrganization->uri;
        });
    }

    /**
     * @test
     */
    public function it_can_list_schedules_events_after_a_given_date(): void
    {
        $knownDate = Carbon::create(2022, 8, 25, 12);
        Carbon::setTestNow($knownDate);

        ScheduledEventsApiClient::list($this->fakeUser, $this->fakeOrganization, [
            'min_start_time' => $knownDate,
        ]);

        Http::assertSent(function (Request $request) use ($knownDate) {
            return $request['min_start_time'] == $knownDate->toISOString();
        });
    }

    /**
     * @test
     */
    public function it_can_list_schedules_events_before_a_given_date(): void
    {
        $knownDate = Carbon::create(2022, 8, 25, 12);
        Carbon::setTestNow($knownDate);

        ScheduledEventsApiClient::list($this->fakeUser, $this->fakeOrganization, [
            'max_start_time' => $knownDate,
        ]);

        Http::assertSent(function (Request $request) use ($knownDate) {
            return $request['max_start_time'] == $knownDate->toISOString();
        });
    }

    /**
     * @test
     */
    public function it_can_list_schedules_events_with_all_options(): void
    {
        $knownDate = Carbon::create(2022, 8, 25, 12);
        Carbon::setTestNow($knownDate);

        ScheduledEventsApiClient::list($this->fakeUser, $this->fakeOrganization, [
            'count' => 1,
            'invitee_email' => 'john@example.com',
            'min_start_time' => $knownDate,
            'max_start_time' => $knownDate,
            'sort' => 'start_time:asc',
            'status' => 'active',
        ]);

        Http::assertSent(function (Request $request) use ($knownDate) {
            return $request['max_start_time'] == $knownDate->toISOString()
                && $request['count'] == 1
                && $request['invitee_email'] == 'john@example.com'
                && $request['max_start_time'] == $knownDate->toISOString()
                && $request['max_start_time'] == $knownDate->toISOString()
                && $request['sort'] == 'start_time:asc'
                && $request['status'] == 'active';
        });
    }
}
