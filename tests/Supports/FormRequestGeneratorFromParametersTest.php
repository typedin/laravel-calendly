<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\FormRequestGeneratorFromParameters;

class FormRequestGeneratorFromParametersTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function path(mixed $filter): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['paths'][$filter])->all();
    }

    /**
     * @test
     */
    public function it_generates_form_request_name_and_namespace(): void
    {
        $generated_class = ( new FormRequestGeneratorFromParameters('ScheduledEvents', 'get', $this->path('/scheduled_events')['get']) )->validator;

        $this->assertEquals('ShowScheduledEventRequest', $generated_class->getName());
    }

    /**
     * @dataProvider ScheduledEventsProvider
     *
     * @test
     */
    public function it_generates_rules_for_scheduled_events($property, $expected_rules): void
    {
        $rules = ( new FormRequestGeneratorFromParameters('ScheduledEvents', 'get', $this->path('/scheduled_events')['get']) )->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function ScheduledEventsProvider(): array
    {
        return [
            ['user', 'url'],
            ['organization', 'url'],
            ['invitee_email', 'email'],
            ['status', 'in:active,canceled'],
            ['sort', 'string'],
            ['max_start_time', 'date'],
            ['min_start_time', 'date'],
        ];
    }

    /**
     * @dataProvider EventTypesProvider
     *
     * @test
     */
    public function it_generates_rules_for_event_types($property, $expected_rules): void
    {
        $rules = ( new FormRequestGeneratorFromParameters('EventTypes', 'get', $this->path('/event_types')['get']) )->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function EventTypesProvider(): array
    {
        return [
            ['active', 'boolean'],
            ['organization', 'url'],
            ['user', 'url'],
            ['sort', 'string'],
        ];
    }

    /**
     * @dataProvider ScheduledEventInviteesProvider
     *
     * @test
     */
    public function it_generates_show_form_request($property, $expected_rules): void
    {
        $sut = ( new FormRequestGeneratorFromParameters('ScheduledEvents', 'get', $this->path('/scheduled_events/{event_uuid}/invitees/{invitee_uuid}')) );

        $this->assertEquals('ShowScheduledEventRequest', $sut->validator->getName());
        $rules = $sut->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function ScheduledEventInviteesProvider(): array
    {
        return [
            ['event_uuid', 'required,string'],
            ['invitee_uuid', 'required,string'],
        ];
    }
}
