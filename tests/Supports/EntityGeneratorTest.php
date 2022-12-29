<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\EntityGenerator;

class EntityGeneratorTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function schema($filter): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['components']['schemas'][$filter])->all();
    }

    /**
     * @test
     */
    public function it_generates_controller_name_and_namespace(): void
    {
        $generated_class = ( new EntityGenerator('User', $this->schema('User')) )->entity;

        $this->assertEquals('CalendlyUser', $generated_class->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Entities\CalendlyUser', $generated_class->getNamespace()->getName());
    }

    /**
     * @test
     */
    public function it_generates_constructor(): void
    {
        $constructor = ( new EntityGenerator('User', $this->schema('User')) )->entity->getMethod('__construct');

        $this->assertCount(10, $constructor->getParameters());
        $uri = $constructor->getParameters()['uri'];
        $this->assertEquals('string', $uri->getType());
        $this->assertStringContainsString('$this->uri = $uri;', $constructor->getBody());
    }

    /**
     * @test
     */
    public function it_generates_properties(): void
    {
        $entity = ( new EntityGenerator('User', $this->schema('User')) )->entity;

        $this->assertCount(10, $entity->getProperties());

        $uri = $entity->getProperties()['uri'];
        $this->assertEquals('string', $uri->getType());
        $this->assertStringContainsString('Canonical reference (unique identifier) for the user', $uri->getComment());
        $this->assertStringContainsString('@var string $uri', $uri->getComment());
    }

    /**
     * @test
     */
    public function it_handles_nullable(): void
    {
        $entity = ( new EntityGenerator('User', $this->schema('User')) )->entity;
        // test constructor parameter
        $avatar_url_parameter = $entity->getMethod('__construct')->getParameters()['avatar_url'];
        $this->assertEquals('string', $avatar_url_parameter->getType());
        $this->assertTrue($avatar_url_parameter->isNullable());

        // test class property
        $avatar_url_property = $entity->getProperties()['avatar_url'];
        $this->assertStringContainsString('@var string|null $avatar_url', $avatar_url_property->getComment());
        $this->assertEquals('string', $avatar_url_property->getType());
    }

    /**
     * @test
     */
    public function it_handles_booleans(): void
    {
        // boolean is an alias for bool
        // https://stackoverflow.com/questions/44009037/php-bool-vs-boolean-type-hinting
        // type hinting and type casting are _not_ the same

        $entity = ( new EntityGenerator('AvailabilitySchedule', $this->schema('AvailabilitySchedule')) )->entity;
        // test constructor parameter
        $avatar_url_parameter = $entity->getMethod('__construct')->getParameters()['default'];
        $this->assertEquals('bool', $avatar_url_parameter->getType());

        // test class property
        $avatar_url_property = $entity->getProperties()['default'];
        $this->assertStringContainsString('@var boolean $default', $avatar_url_property->getComment());
        $this->assertEquals('bool', $avatar_url_property->getType());
    }

    /**
     * @test
     */
    public function it_handles_numbers(): never
    {
        // EventType
        // EventTypeAvailableTime
        // EventTypeCustomQuestion
        // InviteeQuestionAndAnswer
        // Pagination
        // int ?
        // float ?
        // good luck...
        new EntityGenerator('EventType', $this->schema('EventType'));
        $this->markTestIncomplete();
    }

    /**
     * @test
     */
    public function it_generates_enums(): void
    {
        $entity = ( new EntityGenerator('CalendarEvent', $this->schema('CalendarEvent')) )->entity;

        $this->assertCount(2, $entity->getProperties());

        $uri = $entity->getProperties()['kind'];
        $this->assertStringContainsString('Indicates the calendar provider the event belongs to.', $uri->getComment());
        $this->assertStringContainsString('@var string<exchange|google|icloud|outlook|outlook_desktop> $kind', $uri->getComment());
        $this->assertEquals('string', $uri->getType());
    }

    /** @test */
    public function it_works_for_every_key(): void
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');
        $keys = collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['components']['schemas'])->keys();
        $keys->each(function ($key) {
            $entity = ( new EntityGenerator($key, $this->schema($key)) )->entity;
            $this->assertInstanceOf(\Nette\PhpGenerator\ClassType::class, $entity);
        });
    }
}
