<?php

namespace Typedin\LaravelCalendly\Tests\Api;

use ArgumentCountError;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Typedin\LaravelCalendly\Api\BaseApiClient;

class BaseApiClientTest extends \Orchestra\Testbench\TestCase
{
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
    public function it_throws_without_api_url_or_without_api_key(): void
    {
        $this->expectException(ArgumentCountError::class);

        new BaseApiClient();
    }

    /**
     * @test
     */
    public function it_can_get_json_from_api(): void
    {
        Http::fake();

        $apiKey = 'fake-api-key';
        $apiUri = 'https://fake/api/url';

        (new BaseApiClient($apiKey, $apiUri))->get('users/me');

        Http::assertSent(function (Request $request) {
            return
                $request->header('Authorization')[0] == 'Bearer fake-api-key' &&
                $request->url() == 'https://fake/api/url/users/me';
        });
    }
}
