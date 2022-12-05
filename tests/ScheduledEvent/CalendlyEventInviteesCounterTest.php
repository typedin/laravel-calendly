<?php

namespace Typedin\LaravelCalendly\Tests\ScheduledEvent;

use Typedin\LaravelCalendly\Exceptions\CalendlyEventInviteesCounterException;
use Typedin\LaravelCalendly\ScheduledEvent\CalendlyEventInviteesCounter;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyEventInviteesCounterTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'scheduled-events';

    public string $folder_path = __DIR__.'/__fixtures__/';

    public $nested_keys = 'collection.0.invitees_counter';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyEventInviteesCounter($this->nestedKeys());

        $this->assertEquals(42, $sut->total);
        $this->assertEquals(12, $sut->active);
        $this->assertEquals(30, $sut->limit);
    }

    /**
     * @dataProvider providerNestedKey
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyEventInviteesCounterException::class);
        $this->expectExceptionMessage($message);

        new CalendlyEventInviteesCounter($thing);
    }
}
