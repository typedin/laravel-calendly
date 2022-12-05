<?php

namespace Typedin\LaravelCalendly\Tests\ScheduledEvent;

use Typedin\LaravelCalendly\Exceptions\CalendlyEventLocationException;
use Typedin\LaravelCalendly\ScheduledEvent\CalendlyEventLocation;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyEventLocationTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'location';

    public string $folder_path = __DIR__ . '/__fixtures__/';

    public $nested_keys = 'location';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyEventLocation($this->nestedKeys());

        $this->assertEquals('physical', $sut->type);
        $this->assertEquals('Calendly Office', $sut->location);
    }

    /**
     * @dataProvider providerNestedKey
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyEventLocationException::class);
        $this->expectExceptionMessage($message);

        new CalendlyEventLocation($thing);
    }
}
