<?php

namespace Typedin\LaravelCalendly\Tests\Entities\ScheduledEvent;

use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyCalendarEvent;
use Typedin\LaravelCalendly\Exceptions\CalendlyUserException;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyCalendarEventTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'calendar-event';

    public string $folder_path = __DIR__ . '/../__fixtures__/';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyCalendarEvent($this->fixture());

        $this->assertIsString($sut->kind);
        $this->assertIsString($sut->external_id);
    }

    /**
     * @dataProvider providerNestedKey
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyUserException::class);
        $this->expectExceptionMessage($message);

        new CalendlyCalendarEvent($thing);
    }
}
