<?php

namespace Typedin\LaravelCalendly\Tests\Api;

use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Typedin\LaravelCalendly\Api\BaseApiClient;
use Typedin\LaravelCalendly\Exceptions\ApiClientException;

class BaseApiClientTest extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Config::set('calendly.api.key', 'fake-api-key');
        Config::set('calendly.api.endpoint', 'fake/api/endpoint');
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app->useEnvironmentPath(__DIR__);
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        parent::getEnvironmentSetUp($app);
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
    public function it_throws_without_api_key(): void
    {
        Config::set('calendly.api.key', null);

        $this->expectException(ApiClientException::class);
        $this->expectErrorMessage('Expect an API key. None found.');

        new BaseApiClient();
    }

    /**
     * @test
     */
    public function it_throws_without_api_endpoin(): void
    {
        Config::set("calendly.api.endpoint", null);

        $this->expectException(ApiClientException::class);
        $this->expectErrorMessage('Expect an API endpoint. None found.');

        new BaseApiClient();
    }

    /**
     * @test
     */
    public function it_can_get_json_from_api(): void
    {
        Http::fake();

        (new BaseApiClient())->get('users/me');

        Http::assertSent(function (Request $request) {
            return
                $request->header('Authorization')[0] == 'Bearer fake-api-key'
                &&
                $request->url() == 'https://fake/api/endpoint/users/me';
        });
    }
}
