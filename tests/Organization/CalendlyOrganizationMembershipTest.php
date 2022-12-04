<?php

namespace Typedin\LaravelCalenly\Tests\Organization;

use Carbon\Carbon;
use Typedin\LaravelCalenly\CalendlyUser;
use Typedin\LaravelCalenly\Exceptions\CalendlyOrganizationMembershipException;
use Typedin\LaravelCalenly\Organization\CalendlyOrganizationMembership;
use Typedin\LaravelCalenly\Tests\CalendlyTestCase;

class CalendlyOrganizationMembershipTest extends CalendlyTestCase
{
    public string $fixture_file_name = 'organization-membership';

    public string $folder_path = __DIR__ . '/__fixtures__/';

    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyOrganizationMembership($this->fixture());

        $this->assertIsString($sut->uri);
        $this->assertIsString($sut->role);
        $this->assertIsString($sut->organization);

        $this->assertInstanceOf(CalendlyUser::class, $sut->user);

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
        $this->expectException(CalendlyOrganizationMembershipException::class);
        $this->expectExceptionMessage($message);

        new CalendlyOrganizationMembership($thing);
    }
}
