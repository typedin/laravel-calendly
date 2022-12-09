<?php

namespace Typedin\LaravelCalendly\Tests\Repository;

use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;
use Typedin\LaravelCalendly\CalendlyUser;
use Typedin\LaravelCalendly\Repository\UserRepository;

class UserRepositoryTest extends TestCase
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
            "Typedin\LaravelCalendly\LaravelCalendlyServiceProvider",
        ];
    }

    /**
     * @test
     */
    public function it_can_get_current_user(): void
    {
        Http::fake([
            'api.calendly.com/users/me' => Http::response($this->fixture(__DIR__.'/../__fixtures__/current-user'), 200, ['Headers']),
        ]);

        $user = UserRepository::me();

        $this->assertInstanceOf(CalendlyUser::class, $user);

        $this->assertEquals('John Doe', $user->name);

        $this->assertEquals('fake-user-uuid', $user->uuid);
        $this->assertEquals('fake-current-organization-uuid', $user->current_organization);
    }

    protected function fixture($path): mixed
    {
        return json_decode(
            file_get_contents($path.'.json'),
            true
        );
    }
}
