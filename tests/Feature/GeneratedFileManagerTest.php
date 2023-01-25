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
    private $destination = __DIR__.'/../tmp/';

    private function cleanDestinationFolder(): void
    {
        $files = glob($this->destination.'/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
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

        $this->assertCount(17, $controllers);
    }

    /** @test */
    public function it_creates_all_form_requests(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));
        $form_requests = (new GeneratedFileManager($mapper, $this->destination))->createFormRequests()->formRequests;

        $this->assertCount(28, $form_requests);
    }
}
