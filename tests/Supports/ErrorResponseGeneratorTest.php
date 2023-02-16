<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Illuminate\Http\JsonResponse;
use Typedin\LaravelCalendly\Http\Errors\ErrorResponse;
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

    private function schemas(): Collection
    {
        return collect($this->json['components']['schemas']);
    }

    private function responses(): Collection
    {
        return collect($this->json['components']['responses']);
    }

    /**
     * @dataProvider baseErrorResponseGeneratorProvider
     *
     * @test
     */
    public function it_generates_base_error(string $parameterName, bool $isNullable, string $type, array $comments = []): void
    {
        $provider = new BaseErrorResponseGeneratorProvider(
            schema: $this->schemas()->get('ErrorResponse')
        );

        $error_response = ErrorResponseGenerator::errorResponse($provider);

        $this->assertEquals('ErrorResponse', $error_response->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Http\Errors', $error_response->getNamespace()->getName());
        $this->assertNull($error_response->getExtends());
        $this->assertEquals($type, $error_response->getProperty($parameterName)->getType());
        $this->assertEquals($type, $error_response->getMethod('__construct')->getParameters()[$parameterName]->getType());
        $this->assertEquals($isNullable, $error_response->getProperty($parameterName)->isNullable());
        $this->assertEquals($isNullable, $error_response->getMethod('__construct')->getParameters()[$parameterName]->isNullable());

        collect($comments)->each(
            fn ($comment) => $this->assertStringContainsString($comment, $error_response->getProperty($parameterName)->getComment())
        );

        $this->assertEquals('\\' . JsonResponse::class, $error_response->getMethod('toJson')->getReturnType());
        $this->assertStringContainsString('return response()->json(["message" => $this->message, "title" => $this->title, "details" => $this->details], $this->error_code);', $error_response->getMethod('toJson')->getBody());
    }

    public function baseErrorResponseGeneratorProvider()
    {
        return [['title', false, 'string'], ['message', false, 'string'], ['details', true, 'array'], ['error_code', false, 'int']];
    }

    /**
     * @test
     */
    public function it_generates_invalid_argument_response(): void
    {
        $provider = new ErrorResponseGeneratorProvider(
            name:'INVALID_ARGUMENT',
            schema: $this->responses()->get('INVALID_ARGUMENT'),
            error_code: 400
        );

        $error_response = ErrorResponseGenerator::errorResponse($provider);

        $this->assertEquals('InvalidArgumentError', $error_response->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Http\Errors', $error_response->getNamespace()->getName());
        $this->assertEquals('\\' . ErrorResponse::class, $error_response->getExtends());
        $this->assertCount(0, $error_response->getMethods());
    }

    /**
     * @test
     */
    public function it_generates_invalid_already_exists_error(): void
    {
        $provider = new ErrorResponseGeneratorProvider(
            name:'ALREADY_EXISTS',
            schema: $this->responses()->get('ALREADY_EXISTS'),
            error_code: 400
        );

        $error_response = ErrorResponseGenerator::errorResponse($provider);

        $this->assertEquals('AlreadyExistsError', $error_response->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Http\Errors', $error_response->getNamespace()->getName());
        $this->assertEquals('\\' . ErrorResponse::class, $error_response->getExtends());
        $this->assertCount(0, $error_response->getMethods());
    }
}
