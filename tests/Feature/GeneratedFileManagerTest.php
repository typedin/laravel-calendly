<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\NamespaceGenerator;

class GeneratedFileManagerTest extends TestCase
{
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR))->all();
    }

    /** @test */
    public function it_creates_files()
    {
        $destination = __DIR__.'/../../tests/output/';
        $namespace = NamespaceGenerator::generate($this->data());

        GeneratedFileManager::writeAll($namespace, $destination);

        $this->assertCount(8, glob($destination.'*.php'));
    }

    /** @test */
    public function it_catches_excpetions()
    {
        $unexisting_destination = __DIR__.'/this/path/does/not/exist/';
        $this->expectExceptionMessage('Could not write file (UsersApiClient.php) in folder: '.$unexisting_destination);

        $namespace = NamespaceGenerator::generate($this->data());

        GeneratedFileManager::writeAll($namespace, $unexisting_destination);
    }
}
