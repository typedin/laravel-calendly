<?php

namespace Typedin\LaravelCalendly\Tests\Entities\ScheduledEvent;

use Typedin\LaravelCalendly\Entities\ScheduledEvent\CalendlyEventCancellation;
use Typedin\LaravelCalendly\Exceptions\CalendlyCancellationException;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyEventCancellationTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'cancellation';

    public string $folder_path = __DIR__ . '/../__fixtures__/';

    public $nested_keys = 'resource';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyEventCancellation($this->nestedKeys());

        $this->assertEquals('host', $sut->canceler_type);
        $this->assertEquals('John Doe', $sut->canceled_by);
        $this->assertEquals('No more money', $sut->reason);
    }

    /**
     * @dataProvider providerNestedKey
     *
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyCancellationException::class);
        $this->expectExceptionMessage($message);

        new CalendlyEventCancellation($thing);
    }
}
