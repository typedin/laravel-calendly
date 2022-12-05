<?php

namespace Typedin\LaravelCalendly\Tests\Api;

use ArgumentCountError;
use PHPUnit\Framework\TestCase;
use Typedin\LaravelCalendly\Api\CalendlyApi;

class CalendlyApiTest extends TestCase
{
    /**
     * @test
     */
    public function it_throws_without_api_url_or_without_api_key(): void
    {
        $this->expectException(ArgumentCountError::class);

        new CalendlyApi();
    }
}
