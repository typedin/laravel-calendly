<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\Configuration\IndexFormRequestProvider;
use Typedin\LaravelCalendly\Supports\ModelGenerator;

class ModelGeneratorTest extends TestCase
{
    private function path(string $filter): array
    {
        $content = file_get_contents(__DIR__.'/../__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths'][$filter])->all();
    }

    /** @test */
    public function it_generates_models_for_index()
    {
        $dto = new IndexFormRequestProvider(path: '/scheduled_events', name:'ScheduledEvents', value: $this->path('/scheduled_events'));

        $model = ModelGenerator::model($dto);

        $this->assertEquals('Typedin\LaravelCalendly\Model', $model->getExtends());
        $this->assertEquals('ScheduledEvent', $model->getName());
    }
}
