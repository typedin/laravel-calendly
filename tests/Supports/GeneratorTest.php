<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Supports\Generator;
use Typedin\LaravelCalendly\Supports\Mapper;

class GeneratorTest extends TestCase
{
    protected static $data;

    public static function setUpBeforeClass(): void
    {
    }

    /** @test */
    public function it_does_all_the_things(): void
    {
        $paths = Yaml::parse(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
        $data = (new Mapper($paths, 'Scheduled Events'))->handle();

        $result = (new Generator($data))->build();
        dd($result);
    }
}
