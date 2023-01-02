<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class GeneratedFileManagerTest extends TestCase
{
    /**
     * url https://stoplight.io/api/v1/projects/calendly/api-docs/nodes/reference/calendly-api/openapi.yaml
     */
    private $destination = __DIR__.'/../../tests/output/';

    private function cleanDestinationFolder(): void
    {
        $files = glob($this->destination.'/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    /**
     * @test
     * @group integration
     */
    public function it_writes_all_files_to_a_given_path(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));

        (new GeneratedFileManager($mapper, $this->destination))->createEntities()->writeAllFiles();
        (new GeneratedFileManager($mapper, $this->destination))->createControllers()->writeAllFiles();

        $this->assertCount(15, glob($this->destination.'Http/Controllers/*.php'));
        $this->assertCount(45, glob($this->destination.'Entities/*.php'));
        $this->cleanDestinationFolder();
    }

    /** @test */
    public function it_creates_all_entities(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));
        $entities = (new GeneratedFileManager($mapper, $this->destination))->createEntities()->entities;
        $this->assertCount(45, $entities);
    }

    /** @test */
    public function it_creates_all_controllers(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));
        $controllers = (new GeneratedFileManager($mapper, $this->destination))->createControllers()->controllers;

        $this->assertCount(28, $controllers);
    }
}
