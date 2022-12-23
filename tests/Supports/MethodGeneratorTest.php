<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use Nette\PhpGenerator\Parameter;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent;
use Typedin\LaravelCalendly\Supports\MethodGenerator;

class MethodGeneratorTest extends TestCase
{
    private function data(): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/scheduled_events.json');

        return [
            'uri' => '/scheduled_events/{uuid}/invitees',
            'data' => collect(json_decode($content, true)['/scheduled_events/{uuid}/invitees']['methods'])->first(),
        ];
    }

    /**
     * @test
     */
    public function it_creates_method(): void
    {
        $method = MethodGenerator::handle(...$this->data());

        $this->assertEquals($method->getName(), 'ListEventInvitees');
        $this->assertEquals('public', $method->getVisibility());
        $this->assertTrue($method->isStatic());
        $this->assertEquals(CalendlyScheduledEvent::class, $method->getReturnType());
    }

    /**
     * @test
     */
    public function it_creates_params(): void
    {
        $method = MethodGenerator::handle(...$this->data());

        tap($method->getParameters()['uuid'], function (Parameter $uuid) {
            $this->assertFalse($uuid->isNullable());
            $this->assertEquals('string', $uuid->getType());
        });
        tap($method->getParameters()['status'], function (Parameter $status) {
            $this->assertTrue($status->isNullable());
            $this->assertEquals('string', $status->getType());
        });
        /* tap($method->getParameters()['uuid'], function (Parameter $uuid) { */
        /*     $this->assertFalse($uuid->isNullable()); */
        /*     $this->assertEquals('string', $uuid->getType()); */
        /* }); */
        /* tap($method->getParameters()['uuid'], function (Parameter $uuid) { */
        /*     $this->assertFalse($uuid->isNullable()); */
        /*     $this->assertEquals('string', $uuid->getType()); */
        /* }); */
    }

    /**
     * @test
     */
    public function it_creates_body_method(): void
    {
        $method = MethodGenerator::handle(...$this->data());

        $this->assertStringContainsString('$response = BaseApiClient::get("/scheduled_events/{$uuid}/invitees");', $method->getBody());
        $this->assertStringContainsString('return', $method->getBody());
        $this->assertStringContainsString('$response->json("resource"),', $method->getBody());
        $this->assertStringContainsString('new CalendlyScheduledEvent', $method->getBody());
    }

    /**
     * @test
     */
    public function it_creates_doc(): void
    {
        $method = MethodGenerator::handle(...$this->data());

        $this->assertStringContainsString('List Event Invitees', $method->getComment());
        $this->assertStringContainsString('@param string $uuid', $method->getComment());
        $this->assertStringContainsString('@param string $status Indicates if the invitee "canceled" or still "active"', $method->getComment());
        $this->assertStringContainsString('@param string $sort', $method->getComment());
        $this->assertStringContainsString('@param string $email', $method->getComment());
    }
}
