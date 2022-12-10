<?php

namespace Typedin\LaravelCalendly\Tests\Entities\ScheduledEvent;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyEventGuest;
use Typedin\LaravelCalendly\Exceptions\CalendlyEventGuestException;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyEventGuestTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'event-guest';

    public string $folder_path = __DIR__ . '/../__fixtures__/';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyEventGuest($this->fixture());

        $this->assertIsString($sut->email);

        $this->assertInstanceOf(Carbon::class, $sut->created_at);
        $this->assertEquals($sut->created_at->toDateString(), '2019-08-24');

        $this->assertInstanceOf(Carbon::class, $sut->updated_at);
        $this->assertEquals($sut->updated_at->toDateString(), '2019-08-24');
    }

    /**
     * @dataProvider providerNestedKey
     *
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyEventGuestException::class);
        $this->expectExceptionMessage($message);

        new CalendlyEventGuest($thing);
    }
}