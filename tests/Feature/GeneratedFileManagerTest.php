<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

/*
 * @group integration
 */
class GeneratedFileManagerTest extends TestCase
{
    /**
     * url https://stoplight.io/api/v1/projects/calendly/api-docs/nodes/reference/calendly-api/openapi.yaml
     */
    private $destination = __DIR__.'/../../src/';

    /**
     * @test
     *
     * @group integrations
     */
    public function it_writes_all_files_to_a_given_path(): void
    {
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));

        (new GeneratedFileManager($mapper, $this->destination))->createEntities()->writeAllFiles();
        (new GeneratedFileManager($mapper, $this->destination))->createFormRequests()->writeAllFiles();
        (new GeneratedFileManager($mapper, $this->destination))->createControllers()->writeAllFiles();

        $this->assertCount(17, glob($this->destination.'Http/Controllers/*.php'));
        $this->assertCount(34, glob($this->destination.'Http/Requests/*.php'));
        $this->assertCount(45, glob($this->destination.'Entities/*.php'));
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

        $this->assertCount(34, $form_requests);
    }
}
