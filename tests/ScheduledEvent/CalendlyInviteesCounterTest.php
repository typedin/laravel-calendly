<?php

namespace Tests\Unit\Services\Calendly\ScheduledEvent;

use App\Services\Calendly\Exceptions\CalendlyInviteesCounterException;
use App\Services\Calendly\ScheduledEvent\CalendlyInviteesCounter;
use Tests\Unit\CalendlyTestCase;

class CalendlyInviteesCounterTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'scheduled-events';

    public string $folder_path = __DIR__.'/__fixtures__/';

    public $nested_keys = 'collection.0.invitees_counter';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyInviteesCounter($this->nestedKeys());

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
        $this->expectException(CalendlyInviteesCounterException::class);
        $this->expectExceptionMessage($message);

        new CalendlyInviteesCounter($thing);
    }
}
