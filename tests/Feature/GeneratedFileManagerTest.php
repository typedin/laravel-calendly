<?php

namespace Typedin\LaravelCalendly\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Actions\GeneratedFileManager;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

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

    /** @test */
    public function it_writes_a_entities_to_a_given_path(): void
    {
        /**
         * url https://stoplight.io/api/v1/projects/calendly/api-docs/nodes/reference/calendly-api/openapi.yaml
         */
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));
        (new GeneratedFileManager($mapper, $this->destination))->writeEntities();

        $this->assertCount(45, glob($this->destination.'Entities/*.php'));
    }

    /** @test */
    public function it_writes_a_controllers_to_a_given_path(): void
    {
        /**
         * url https://stoplight.io/api/v1/projects/calendly/api-docs/nodes/reference/calendly-api/openapi.yaml
         */
        $yaml = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
        $mapper = (new EndpointMapper($yaml));
        (new GeneratedFileManager($mapper, $this->destination))->writeControllers();

        $this->assertCount(15, glob($this->destination.'Http/Controllers/*.php'));
    }
}
