<?php

namespace Typedin\LaravelCalendly\Tests\Parsers;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Parsers\DocParser;

class DocParserTest extends TestCase
{
    /**
     * @var string|bool
     */
    private $input;

    protected function setUp(): void
    {
        parent::setUp();

        $this->input = file_get_contents(__DIR__.'/../../doc/openapi.yaml');
    }

    /**
     * @test
     */
    public function it_can_parse_yaml(): void
    {
        $result = ( new DocParser($this->input) )->paths();

        $this->assertCount(28, $result);
    }
}
