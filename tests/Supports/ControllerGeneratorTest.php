<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;

class ControllerGeneratorTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function endpoints(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths'];
    }

    /**
     * @test
     */
    public function it_generates_controller_name_and_namespace(): void
    {
        $generated_class = ( new ControllerGenerator('Users', $this->endpoints()) )->controller;

        $this->assertEquals('CalendlyUsersController', $generated_class->getName());
        $this->assertEquals('Typedin\LaravelCalendly\Http\Controllers\CalendlyUsersController', $generated_class->getNamespace()->getName());
    }

    /**
     * @test
     */
    public function it_generates_constructor(): void
    {
        $constructor = ( new ControllerGenerator('Users', $this->endpoints()) )->controller->getMethod('__construct');

        $this->assertStringContainsString('$this->api = $api;', $constructor);
    }

    /**
     * @test
     */
    public function it_generates_show_method(): void
    {
        $method = ( new ControllerGenerator('Users', $this->endpoints()) )->controller->getMethod('show');

        $this->assertEquals('\Typedin\LaravelCalendly\Http\GetUserRequest', $method->getParameters()['request']->getType());
        $this->assertStringContainsString('$this->api->get("/users/{$uuid}");', $method->getBody());
    }
}
