<?php

namespace Typedin\LaravelCalendly\Tests\Supports;

use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Supports\FormRequestGenerator;

class FormRequestGeneratorTest extends TestCase
{
    /**
     * @return array<TKey,TValue>
     */
    private function schema($filter): array
    {
        $content = file_get_contents(__DIR__.'/__fixtures__/api.json');

        return collect(json_decode($content, true, 512, JSON_THROW_ON_ERROR)['components']['schemas'][$filter])->all();
    }

    /**
     * @test
     */
    public function it_generates_controller_name_and_namespace(): void
    {
        $generated_class = ( new FormRequestGenerator('EventType', $this->schema('EventType')) )->validator;

        $this->assertEquals('EventTypeRequest', $generated_class->getName());
    }

    /**
     * @dataProvider EventTypeProvider
     *
     * @test
     */
    public function it_generates_rules_for_event_typed($property, $expected_rules): void
    {
        $rules = ( new FormRequestGenerator('EventType', $this->schema('EventType')) )->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function EventTypeProvider(): array
    {
        return [
            ['uri', 'required,url'],
            ['name', 'nullable,string'],
            ['active',  'required,boolean'],
            ['slug', 'nullable,string'],
            ['scheduling_url', 'required,url'],
            ['duration', 'required,numeric'],
            ['kind', 'required,in:solo,group'],
            ['pooling_type', 'nullable,in:round_robin,collective'],
            ['type', 'required,in:StandardEventType,AdhocEventType'],
            ['color', 'required,regex:^#[a-f\\d]{6}$'],
            ['created_at', 'required,date'],
            ['updated_at', 'required,date'],
            ['internal_note', 'nullable,string'],
            ['description_plain', 'nullable,string'],
            ['description_html', 'nullable,string'],
            ['secret',  'required,boolean'],
            ['booking_method', 'required,in:instant,poll'],
            ['deleted_at', 'nullable,date'],
            ['kind_description', 'required,in:Collective,Group,One-on-One,Round Robin'],
            ['admin_managed', 'required,boolean'],
            // TODO
            // profile
            // custom question
        ];
    }

    /**
     * @dataProvider EventProvider
     *
     * @test
     */
    public function it_generates_rules_for_event($property, $expected_rules): void
    {
        $rules = ( new FormRequestGenerator('Event', $this->schema('Event')) )->validator->getMethod('rules');

        $this->assertStringContainsString(sprintf("'%s' => '%s',", $property, $expected_rules), $rules->getBody());
    }

    public function EventProvider(): array
    {
        return [
            ['uri', 'required,url'],
            ['name', 'nullable,string'],
            ['status', 'required,in:active,canceled'],
            ['start_time', 'required,date'],
            ['end_time', 'required,date'],
            ['created_at', 'required,date'],
            ['updated_at', 'required,date'],
            ['event_type', 'required,url'],
            ["event_memberships", "required,array"],
            /* ["event_memberships.*.user", "required,array"] */
            // TODO
            // location 
            // event_guests
            // cancellation 
            // calendar_event
        ];
    }
}
