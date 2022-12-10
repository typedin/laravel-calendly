<?php

namespace Typedin\LaravelCalendly\Tests\Entities\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyScheduledEvent;
use Typedin\LaravelCalendly\Exceptions\CalendlyScheduledEventException;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyScheduledEventTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'scheduled-events';

    public string $folder_path = __DIR__ . '/../__fixtures__/';

    public $nested_keys = 'collection.0';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyScheduledEvent($this->nestedKeys(), $this->base_url);

        $this->assertIsString($sut->event_type);
        $this->assertIsString($sut->name);
        $this->assertIsString($sut->status);
        $this->assertIsString($sut->uri);
        $this->assertIsString($sut->uuid);

        $this->assertIsArray($sut->calendar_event);
        $this->assertIsArray($sut->event_guests);
        $this->assertIsArray($sut->event_memberships);
        $this->assertIsArray($sut->invitees_counter);
        $this->assertIsArray($sut->location);

        $this->assertInstanceOf(Carbon::class, $sut->created_at);
        $this->assertInstanceOf(Carbon::class, $sut->end_time);
        $this->assertInstanceOf(Carbon::class, $sut->start_time);
        $this->assertInstanceOf(Carbon::class, $sut->updated_at);
    }

    /**
     * @dataProvider providerNestedKey
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyScheduledEventException::class);
        $this->expectExceptionMessage($message);

        new CalendlyScheduledEvent($thing, $this->base_url);
    }
}
