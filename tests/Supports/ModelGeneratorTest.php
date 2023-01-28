<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use TValue;
use Typedin\LaravelCalendly\Supports\Configuration\IndexModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ShowModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\StoreModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\ModelGenerator;

class ModelGeneratorTest extends TestCase
{
    private array $json;

    protected function setUp(): void
    {
        parent::setUp();

        $content = file_get_contents(__DIR__.'/../__fixtures__/api.json');
        $this->json = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<TKey,TValue>
     */
    private function components(): array
    {
        return collect($this->json['components'])->all();
    }

    /**
     * @return array<TKey,TValue>
     */
    private function path(string $filter): array
    {
        return collect($this->json['paths'][$filter])->all();
    }

    /** @test */
    public function it_generates_models_for_index(): void
    {
        $provider = new IndexModelGeneratorProvider(
            path: '/scheduled_events',
            name:'ScheduledEvents',
            value: $this->path('/scheduled_events'),
            components: $this->components()
        );

        $model = ModelGenerator::model($provider);
        // in the controller handle responses

        $this->assertEquals('Event', $model->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Models', $model->getNamespace()->getName());

        $cancellation = $model->getProperties()['cancellation'];
        $this->assertEquals('Cancellation', $cancellation->getType());
        $this->assertStringContainsString('@var Typedin\LaravelCalendly\Models\Cancellation $cancellation', $cancellation->getComment());
        $this->assertStringContainsString('Provides data pertaining to the cancellation of the Event', $cancellation->getComment());
    }

    /**
     * @dataProvider showProvider
     *
     * @test
     *
     * @param  string  $parameterName
     * @param  string  $type
     * @param  bool  $isNullable
     * @param  array<int,string>  $comments
     */
    public function it_generates_models_for_show($parameterName, $isNullable, $type, $comments = []): void
    {
        $provider = new ShowModelGeneratorProvider(
            path: '/users/{uuid}',
            name:'Users',
            value: $this->path('/users/{uuid}'),
            components: $this->components()
        );

        $model = ModelGenerator::model($provider);

        $this->assertEquals('User', $model->getName());

        $this->assertEquals($type, $model->getProperty($parameterName)->getType());
        $this->assertEquals($type, $model->getMethod('__construct')->getParameters()[$parameterName]->getType());
        $this->assertEquals($isNullable, $model->getProperty($parameterName)->isNullable());
        $this->assertEquals($isNullable, $model->getMethod('__construct')->getParameters()[$parameterName]->isNullable());

        collect($comments)->each(
            fn ($comment) => $this->assertStringContainsString($comment, $model->getProperty($parameterName)->getComment())
        );
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    private function showProvider(): array
    {
        return [
            [
                'uri',  false, 'string', ['Canonical reference (unique identifier) for the user', '@var string $uri'],
            ],
            [
                'name',  false, 'string', ["The user's name (human-readable format)",  '@var string $name',
                ],
            ],
            [
                'slug',  false, 'string', ["The portion of URL for the user's scheduling page (where invitees book sessions), rendered in a human-readable format"],
            ],
            [
                'email',  false, 'string',
            ],
            [
                'scheduling_url',  false, 'string',
            ],
            [
                'timezone',  false, 'string',
            ],
            [
                'avatar_url',  true, 'string',
            ],
            [
                'created_at',  false, 'string',
            ],
            [
                'updated_at',  false, 'string',
            ],
            [
                'current_organization',  false, 'string',
            ],
        ];
    }

    /**
     * @dataProvider storeProvider
     *
     *  @test
     */
    public function it_generates_models_for_store(string $parameterName, bool $isNullable, string $type, array $comments = []): void
    {
        $provider = new StoreModelGeneratorProvider(
            path: '/webhook_subscriptions',
            name:'WebhookSubscriptions',
            value: $this->path('/webhook_subscriptions'),
            components: $this->components()
        );

        $model = ModelGenerator::model($provider);
        $this->assertEquals('WebhookSubscription', $model->getName());

        $this->assertEquals($type, $model->getProperty($parameterName)->getType());
        $this->assertEquals($type, $model->getMethod('__construct')->getParameters()[$parameterName]->getType());
        $this->assertEquals($isNullable, $model->getProperty($parameterName)->isNullable());
        $this->assertEquals($isNullable, $model->getMethod('__construct')->getParameters()[$parameterName]->isNullable());

        collect($comments)->each(
            fn ($comment) => $this->assertStringContainsString($comment, $model->getProperty($parameterName)->getComment())
        );
    }

    /**
     * @return array<int,array<int,mixed>>
     */
    private function storeProvider(): array
    {
        return [
            [
                'uri',  false, 'string',
            ],
            [
                'callback_url',  false, 'string',
            ],
            [
                'created_at',  false, 'string',
            ],
            [
                'updated_at',  false, 'string',
            ],
            [
                'retry_started_at',  true, 'string',
            ],
            [
                'state',  false, 'string',
            ],
            [
                'events',  false, 'array',
            ],
            [
                'scope',  false, 'string',
            ],
            [
                'organization',  false, 'string',
            ],
            [
                'user',  true, 'string',
            ],
            [
                'creator',  true, 'string',
            ],
        ];
    }
}
