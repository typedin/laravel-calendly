<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use Nette\PhpGenerator\PhpNamespace;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\EntityGenerator;
use Typedin\LaravelCalendly\Supports\NamespaceGenerator;

/**
 * @group integration
 */
class GeneratedFileManagerTest extends TestCase
{
    private $destination = __DIR__.'/../../tests/output/';

    protected function tearDown(): void
    {
        parent::tearDown();
        $files = glob($this->destination.'/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    /**
     * @return array<TKey,TValue>
     */
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR))->all();
    }

    /** @test */
    public function it_creates_files(): void
    {
        $namespace = NamespaceGenerator::generate($this->data());

        GeneratedFileManager::writeAll($namespace, $this->destination);

        $this->assertCount(8, glob($this->destination.'*.php'));
    }

    /** @test */
    public function it_catches_exceptions(): void
    {
        $unexisting_destination = __DIR__.'/this/path/does/not/exist/';
        $this->expectExceptionMessage('Could not write file (UsersApiClient.php) in folder: '.$unexisting_destination);

        $namespace = NamespaceGenerator::generate($this->data());

        GeneratedFileManager::writeAll($namespace, $unexisting_destination);
    }

    /** @test */
    public function it_works_for_every_key_for_entities(): void
    {
        /**
         * url https://stoplight.io/api/v1/projects/calendly/api-docs/nodes/reference/calendly-api/openapi.yaml
         */
        $content = collect(Yaml::parseFile(__DIR__.'/../../doc/openapi.yaml'));
        $schemas = $content['components']['schemas'];
        $keys = collect($content['components']['schemas'])->keys();

        $keys->each(function ($key) use ($schemas) {
            $entity = ( new EntityGenerator($key, $schemas[$key]) )->entity;
            $namespace = new PhpNamespace(name: "Typedin\LaravelCalendly\Entities\\".$entity->getName());
            GeneratedFileManager::write(path: $this->destination, class: $entity, namespace: $namespace);
        });
        $this->assertCount(45, glob($this->destination.'*.php'));
    }
}
