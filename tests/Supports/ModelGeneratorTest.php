<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use TValue;
use Typedin\LaravelCalendly\Supports\Configuration\IndexModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ShowModelGeneratorProvider;
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
        $this->assertEquals('Typedin\LaravelCalendly\Model', $model->getExtends());
        $this->assertEquals('Event', $model->getName());
    }

    /** @test */
    public function it_generates_models_for_show(): void
    {
        $provider = new ShowModelGeneratorProvider(
            path: '/users/{uuid}',
            name:'Users',
            value: $this->path('/users/{uuid}'),
            components: $this->components()
        );

        $model = ModelGenerator::model($provider);
        // in the controller handle responses
        $this->assertEquals('Typedin\LaravelCalendly\Model', $model->getExtends());
        $this->assertEquals('User', $model->getName());
    }
}
