<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Supports\Configuration\BaseErrorResponseGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ErrorResponseGeneratorProvider;
use Typedin\LaravelCalendly\Supports\ErrorResponseGenerator;

class ErrorResponseGeneratorTest extends TestCase
{
    private array $json;

    protected function setUp(): void
    {
        parent::setUp();

        $this->json = Yaml::parse(file_get_contents(__DIR__.'/../../doc/openapi.yaml'));
    }

    /**
     * @return array<TKey,TValue>
     */
    private function schemas(): Collection
    {
        return collect($this->json['components']['schemas']);
    }

    /**
     * @return array<TKey,TValue>
     */
    private function responses(): Collection
    {
        return collect($this->json['components']['responses']);
    }

    /**
     * @dataProvider baseErrorResponseGeneratorProvider
     *
     * @test
     */
    public function it_generates_base_error($parameterName, $isNullable, $type, $comments = []): void
    {
        $provider = new BaseErrorResponseGeneratorProvider(
            schema: $this->schemas()->get('ErrorResponse')
        );

        $error_response = ErrorResponseGenerator::errorResponse($provider);

        $this->assertEquals('ErrorResponse', $error_response->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Errors', $error_response->getNamespace()->getName());
        $this->assertNull($error_response->getExtends());
        $this->assertEquals($type, $error_response->getProperty($parameterName)->getType());
        $this->assertEquals($type, $error_response->getMethod('__construct')->getParameters()[$parameterName]->getType());
        $this->assertEquals($isNullable, $error_response->getProperty($parameterName)->isNullable());
        $this->assertEquals($isNullable, $error_response->getMethod('__construct')->getParameters()[$parameterName]->isNullable());

        collect($comments)->each(
            fn ($comment) => $this->assertStringContainsString($comment, $error_response->getProperty($parameterName)->getComment())
        );
    }

    public function baseErrorResponseGeneratorProvider()
    {
        return [['title', false, 'string'], ['message', false, 'string']];
    }

    /**
     * @dataProvider invalidArgumentProvider
     *
     * @test
     */
    public function it_generates_invalid_argument_response($parameterName, $isNullable, $type, $comments = []): void
    {
        $provider = new ErrorResponseGeneratorProvider(
            name:'INVALID_ARGUMENT',
            schema: $this->responses()->get('INVALID_ARGUMENT')
        );

        $error_response = ErrorResponseGenerator::errorResponse($provider);

        $this->assertEquals('InvalidArgumentError', $error_response->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Errors', $error_response->getNamespace()->getName());
        $this->assertEquals('\Typedin\LaravelCalendly\Models\ErrorResponse', $error_response->getExtends());

        $this->assertEquals($type, $error_response->getProperty($parameterName)->getType());
        $this->assertEquals($type, $error_response->getMethod('__construct')->getParameters()[$parameterName]->getType());
        $this->assertEquals($isNullable, $error_response->getProperty($parameterName)->isNullable());
        $this->assertEquals($isNullable, $error_response->getMethod('__construct')->getParameters()[$parameterName]->isNullable());

        collect($comments)->each(
            fn ($comment) => $this->assertStringContainsString($comment, $error_response->getProperty($parameterName)->getComment())
        );
    }

    public function invalidArgumentProvider()
    {
        return [['title', false, 'string'], ['message', false, 'string']];
    }
}
