<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Supports\Mapper;

class MapperTest extends TestCase
{
    private Mapper $sut;

    protected function setUp(): void
    {
        parent::setup();
        $paths = Yaml::parse(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));

        $this->sut = (new Mapper($paths, 'Scheduled Events'));
    }

    /** @test */
    public function it_collects_maps_rest_methods_to_uri(): void
    {
        $result = $this->sut->handle()->all();

        $this->assertCount(5, $result);

        $this->assertEquals('/scheduled_events/{uuid}/invitees', $result['/scheduled_events/{uuid}/invitees']['uri']);
        $this->assertCount(1, $result['/scheduled_events/{uuid}/invitees']['methods']);
        $this->assertTrue(in_array('get', array_keys($result['/scheduled_events/{uuid}/invitees']['methods'])));
    }
}
