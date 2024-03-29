<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Supports\Configuration\ModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\ModelGenerator;

class ModelGeneratorTest extends TestCase
{
    private array $json;

    protected function setUp(): void
    {
        $this->json = Yaml::parse(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
    }

    /**
     * @return Collection
     */
    private function shemas(): Collection
    {
        return collect($this->json['components']['schemas']);
    }

    /**
     * @dataProvider userSchemaProvider
     *
     * @test */
    public function it_generates_models_for_index(string $parameterName, bool $isNullable, string $type, array $comments = []): void
    {
        $provider = new ModelGeneratorProvider(
            name:'User',
            schema: $this->shemas()->get('User')
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
     * @return array
     */
    private function userSchemaProvider(): array
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
        $key = 'WebhookSubscription';
        $provider = new ModelGeneratorProvider(
            name: $key,
            schema: $this->shemas()->get($key)
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
     * @return array
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

    /**
     * @dataProvider paginationProvider
     *
     * @test
     */
    public function it_generates_the_right_types_for_numbers(string $parameterName, bool $isNullable, string $type, array $comments = [])
    {
        $key = 'Pagination';
        $provider = new ModelGeneratorProvider(
            name: $key,
            schema: $this->shemas()->get($key)
        );

        $model = ModelGenerator::model($provider);
        $this->assertEquals('Pagination', $model->getName());

        $this->assertEquals($type, $model->getProperty($parameterName)->getType());
        $this->assertEquals($type, $model->getMethod('__construct')->getParameters()[$parameterName]->getType());
        $this->assertEquals($isNullable, $model->getProperty($parameterName)->isNullable());
        $this->assertEquals($isNullable, $model->getMethod('__construct')->getParameters()[$parameterName]->isNullable());

        collect($comments)->each(
            fn ($comment) => $this->assertStringContainsString($comment, $model->getProperty($parameterName)->getComment())
        );
    }

    /**
     * @return array
     */
    private function paginationProvider(): array
    {
        return [
            [
                'count',  false, 'float', [
                    'The number of rows to return',
                    '@var float $count',
                ],
            ],
            [
                'next_page',  true, 'string',
            ],
            [
                'previous_page',  true, 'string',
            ],
            [
                'next_page_token',  true, 'string',
            ],
            [
                'previous_page_token',  true, 'string',
            ],
        ];
    }
}
