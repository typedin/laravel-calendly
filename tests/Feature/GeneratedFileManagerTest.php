<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use Nette\PhpGenerator\PhpNamespace;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\EntityGenerator;

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

    private function data($key = null)
    {
        $content = collect(Yaml::parseFile(__DIR__.'/../../doc/openapi.yaml'));
        $schemas = $content['components']['schemas'];
        $keys = collect($content['components']['schemas'])->keys();

        $local = [
            'keys' => $keys,
            'schemas' => $schemas,
        ];
        if ($key) {
            return $local[$key];
        }

        return $local;
    }

    /** @test */
    public function it_catches_exceptions(): void
    {
        $unexisting_destination = __DIR__.'/this/path/does/not/exist/';

        $this->expectExceptionMessage('Could not write file (CalendlyUser.php) in folder: '.$unexisting_destination);

        $entity = ( new EntityGenerator('User', $this->data()['schemas']['User']) )->entity;
        $namespace = new PhpNamespace(name: "Typedin\LaravelCalendly\Entities\CalendlyUser");
        GeneratedFileManager::write(path: $unexisting_destination, class: $entity, namespace: $namespace);
    }

    /** @test */
    public function it_writes_a_file_to_a_specific_path(): void
    {
        /**
         * url https://stoplight.io/api/v1/projects/calendly/api-docs/nodes/reference/calendly-api/openapi.yaml
         */
        $schemas = $this->data('schemas');

        $this->data('keys')->each(function ($key) use ($schemas) {
            $entity = ( new EntityGenerator($key, $schemas[$key]) )->entity;
            $namespace = new PhpNamespace(name: "Typedin\LaravelCalendly\Entities\\".$entity->getName());
            GeneratedFileManager::write(path: $this->destination, class: $entity, namespace: $namespace);
        });
        $this->assertCount(45, glob($this->destination.'*.php'));
    }
}
