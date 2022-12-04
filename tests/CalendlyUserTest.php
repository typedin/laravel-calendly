<?php

namespace Typedin\LaravelCalenly\Tests;

use App\Services\Calendly\Exceptions\CalendlyUserException;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalenly\CalendlyUser;

class CalendlyUserTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_be_instanciate(): void
    {
        $sut = new CalendlyUser($this->fixture('current-user')['resource']);

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

        new CalendlyUser($thing);
    }

    /**
     * @return array<int,array>
     */
    private function providerNestedKey(): array
    {
        return collect($this->fixture('current-user')['resource'])
            ->map(fn ($item, $key) => [
                'Expect argument with '.$key.' key.',
                $this->getClonedFixtureWithoutKey($key),
            ])
            ->all();
    }

    private function getClonedFixtureWithoutKey($key): array
    {
        $clone = clone_array($this->fixture('current-user')['resource']);
        unset($clone[$key]);

        return $clone;
    }

    private function fixture(string $filename): mixed
    {
        return json_decode(
            file_get_contents(__DIR__.'/__fixtures__/'.$filename.'.json'),
            true
        );
    }
}
