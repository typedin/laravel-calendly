<?php

namespace Typedin\LaravelCalendly\Tests\Entities\Organization;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\Organization\CalendlyOrganization;
use Typedin\LaravelCalendly\Exceptions\CalendlyOrganizationException;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyOrganizationTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'organization';

    public string $folder_path = __DIR__.'/../__fixtures__/';

    public $nested_keys = 'resource';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyOrganization($this->nestedKeys(), $this->base_url);

        $this->assertIsString($sut->uri);
        $this->assertIsString($sut->plan);
        $this->assertIsString($sut->stage);

        $this->assertIsString($sut->uuid);
        $this->assertEquals($sut->uuid, 'fake-organization-uuid');

        $this->assertInstanceOf(Carbon::class, $sut->created_at);
        $this->assertEquals($sut->created_at->toDateString(), '2019-01-02');

        $this->assertInstanceOf(Carbon::class, $sut->updated_at);
        $this->assertEquals($sut->updated_at->toDateString(), '2019-08-07');
    }

    /**
     * @dataProvider providerNestedKey
     * @test
     */
    public function it_throws_exceptions_without_nested_keys($message, $thing): void
    {
        $this->expectException(CalendlyOrganizationException::class);
        $this->expectExceptionMessage($message);

        new CalendlyOrganization($thing, $this->base_url);
    }
}
