<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\CreateFile;
use Typedin\LaravelCalendly\Supports\NamespaceGenerator;

class CreateFileTest extends TestCase
{
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true))->all();
    }

    /** @test */
    public function it_creates_files()
    {
        $namespace = NamespaceGenerator::generate($this->data());

        (new CreateFile($namespace))->write(__DIR__.'/../../tests/output/');

        $this->assertCount(8, glob(__DIR__.'/../../tests/output/*.php'));
    }
}
