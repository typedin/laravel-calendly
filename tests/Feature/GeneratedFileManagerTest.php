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
    private string $destination = __DIR__.'/../tmp/';

    protected static string $yaml;

    private GeneratedFileManager $file_manager;

    public static function setUpBeforeClass(): void
    {
        self::$yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
    }

    private function cleanDestinationFolder(): void
    {
        $files = glob($this->destination.'/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }

    protected function setUp(): void
    {
        $this->file_manager = new GeneratedFileManager(new EndpointMapper(self::$yaml), $this->destination);
    }

    protected function tearDown(): void
    {
        $this->cleanDestinationFolder();
    }

    /** @test */
    public function it_creates_all_models(): void
    {
        $models = $this->file_manager->createModels()->models;

        // error is not considered to be a model
        $this->assertCount(44, $models);
    }

    /** @test */
    public function it_creates_all_controllers(): void
    {
        $controllers = $this->file_manager->createControllers()->controllers;

        $this->assertCount(28, $controllers);
    }

    /** @test */
    public function it_creates_all_form_requests(): void
    {
        $form_requests = $this->file_manager->createFormRequests()->formRequests;

        $this->assertCount(34, $form_requests);
    }

    /** @test */
    public function it_creates_all_routes(): void
    {
        $routes = $this->file_manager->createRoutes()->routes;

        $this->assertCount(34, $routes);
    }

    /** @test */
    public function it_creates_all_error_responses(): void
    {
        $error_responses = $this->file_manager->createErrorResponses()->errorResponses;

        // one error in schema
        $this->assertCount(7, $error_responses);
    }
}
