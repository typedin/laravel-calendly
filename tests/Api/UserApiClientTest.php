<?php

namespace Typedin\LaravelCalendly\Tests\Api;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use Typedin\LaravelCalendly\Api\UserApiClient;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;

class UserApiClientTest extends TestCase
{
    protected $loadEnvironmentVariables = true;

    protected function setUp(): void
    {
        parent::setUp();
        config()->set('calendly', [
            'api' => [
                'key' => 'a-fake-api-key',
                'endpoint' => 'api.calendly.com',
            ],
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            \Typedin\LaravelCalendly\LaravelCalendlyServiceProvider::class,
        ];
    }

    /**
     * @test
     */
    public function it_can_get_current_user(): void
    {
        Http::fake([
            'api.calendly.com/users/me' => Http::response($this->fixture(__DIR__.'/../Entities/__fixtures__/current-user'), 200, ['Headers']),
        ]);

        $user = UserApiClient::me();

        $this->assertInstanceOf(CalendlyUser::class, $user);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('fake-user-uuid', $user->uuid);
        $this->assertEquals('fake-current-organization-uuid', $user->current_organization);
    }

    /**
     * @test
     */
    public function it_can_get_a_user_by_uuid(): void
    {
        Http::fake([
            'api.calendly.com/users/a-user-uuid' => Http::response($this->fixture(__DIR__.'/../Entities/__fixtures__/a-user'), 200, ['Headers']),
        ]);

        $user = UserApiClient::fetchByUUID('a-user-uuid');

        $this->assertInstanceOf(CalendlyUser::class, $user);

        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('a-user-uuid', $user->uuid);
        $this->assertEquals('AAAAAAAAAAAAAAAA', $user->current_organization);
    }

    protected function fixture($path): mixed
    {
        return json_decode(
            file_get_contents($path.'.json'),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
