<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent;
use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEventsCollection;
use Typedin\LaravelCalendly\Supports\ClassGenerator;

class ClassGeneratorTest extends TestCase
{
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/scheduled_events.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR))->all();
    }

    /**
     * @test
     */
    public function it_creates_class_with_a_name(): void
    {
        $tag = 'Scheduled Events';

        $class = ClassGenerator::generate($tag, $this->data());
        $this->assertEquals('ScheduledEventsApiClient', $class->getName());
    }

    /**
     * @test
     */
    public function it_creates_add_methods_to_class(): void
    {
        $tag = 'Scheduled Events';
        $class = ClassGenerator::generate($tag, $this->data());

        $this->assertCount(5, $class->getMethods());
    }

    /** @test */
    public function it_generates_get_methods_with_entities_as_return_types()
    {
        $tag = 'Scheduled Events';
        $method = ClassGenerator::generate($tag, $this->data())->getMethod('GetEvent');

        $this->assertEquals(CalendlyScheduledEvent::class, $method->getReturnType());
        $this->assertTrue(str_contains($method->getBody(), 'CalendlyScheduledEvent'));
    }

    /** @test */
    public function it_generates_list_methods_with_collections_as_return_types()
    {
        $tag = 'Scheduled Events';
        $method = ClassGenerator::generate($tag, $this->data())->getMethod('ListEventInvitees');

        $this->assertEquals(CalendlyScheduledEventsCollection::class, $method->getReturnType());
        $this->assertTrue(str_contains($method->getBody(), 'CalendlyScheduledEventCollection'));
    }

    /** @test */
    public function it_generates_delete_method_with_no_entities()
    {
        $this->markTestIncomplete();
    }
}
