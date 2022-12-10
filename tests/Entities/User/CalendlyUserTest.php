<?php

namespace Typedin\LaravelCalendly\Tests\Entities\User;

use Carbon\Carbon;
use Typedin\LaravelCalendly\Entities\User\CalendlyUser;
use Typedin\LaravelCalendly\Exceptions\CalendlyUserException;
use Typedin\LaravelCalendly\Tests\CalendlyTestCase;

class CalendlyUserTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'current-user';

    public string $folder_path = __DIR__.'/../__fixtures__/';

    public $nested_keys = 'resource';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyUser($this->nestedKeys(), $this->base_url);

        $this->assertIsString($sut->avatar_url);

        $this->assertIsString($sut->current_organization);
        $this->assertEquals($sut->current_organization, 'fake-current-organization-uuid');

        $this->assertIsString($sut->email);
        $this->assertIsString($sut->name);
        $this->assertIsString($sut->scheduling_url);
        $this->assertIsString($sut->slug);
        $this->assertIsString($sut->timezone);
        $this->assertIsString($sut->uri);

        $this->assertIsString($sut->uuid);
        $this->assertEquals($sut->uuid, 'fake-user-uuid');

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
        $this->expectException(CalendlyUserException::class);
        $this->expectExceptionMessage($message);

        new CalendlyUser($thing, $this->base_url);
    }
}
