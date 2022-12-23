<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\NamespaceGenerator;

class NamespaceGeneratorTest extends TestCase
{
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true))->all();
    }

    /** @test */
    public function it_creates_namespace()
    {
        $namespace = NamespaceGenerator::generate($this->data());

        $this->assertEquals('Typedin\LaravelCalendly\Api', $namespace->getName());
        $this->assertCount(8, $namespace->getClasses());
    }
}
