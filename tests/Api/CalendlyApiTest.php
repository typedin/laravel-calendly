<?php

namespace Typedin\LaravelCalendly\Tests\Api;

use ArgumentCountError;
use Typedin\LaravelCalendly\Api\CalendlyApi;
use Typedin\LaravelCalendly\CalendlyUser;

/**
 * @group integration
 */
class CalendlyApiTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            "Typedin\LaravelCalendly\LaravelCalendlyServiceProvider",
        ];
    }

    /**
     * @test
     */
    public function it_throws_without_api_url_or_without_api_key(): void
    {
        $this->expectException(ArgumentCountError::class);

        new CalendlyApi();
    }

    /**
     * @test
     */
    public function it_can_fetch_the_current_user(): void
    {
        $apiKey = config('laravel-calendly.api.key');
        $apiUrl = config('laravel-calendly.api.endpoint');

        $user = (new CalendlyApi($apiKey, $apiUrl))->getUser();

        $this->assertInstanceOf(CalendlyUser::class, $user);
    }

    /**
     * @test
     */
    public function it_can_fetch_scheduled_events(): void
    {
        $apiKey = config('laravel-calendly.api.key');
        $apiUrl = config('laravel-calendly.api.endpoint');

        $user = (new CalendlyApi($apiKey, $apiUrl))->getUser();

        $response = (new CalendlyApi($apiKey, $apiUrl))->listScheduledEvents($user);

        $this->assertNotNull($response);
    }
}
