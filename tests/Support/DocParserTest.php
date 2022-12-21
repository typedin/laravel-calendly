<?php

namespace Typedin\LaravelCalendly\Tests\Support;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Support\BuilderFromDoc;
use Typedin\LaravelCalendly\Support\Thing;

class DocParserTest extends TestCase
{
    private $input;

    protected function setUp(): void
    {
        parent::setUp();

        $this->input = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
    }

    /**
     * @test
     */
    public function it_can_build_entities_from_yaml(): void
    {
        $result = BuilderFromDoc::handle($this->input);

        $this->assertCount(28, $result);
        $this->assertInstanceOf(Thing::class, $result->first());
    }
}
