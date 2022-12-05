<?php

namespace Typedin\LaravelCalendly\Tests;

use PHPUnit\Framework\TestCase;

abstract class CalendlyTestCase extends TestCase
{
    public string $base_url = "https://api.calendly.com";

    public string $fixture_file_name;

    public string $folder_path;

    public $nested_keys = null;

    /**
     * @return mixed
     */
    protected function nestedKeys()
    {
        return (new \Adbar\Dot($this->fixture()))->get($this->nested_keys);
    }

    private function fixtureFullPath(): string
    {
        return $this->folder_path.$this->fixture_file_name;
    }

    protected function fixture(): mixed
    {
        return json_decode(
            file_get_contents($this->fixtureFullPath().'.json'),
            true
        );
    }

    /**
     * @return array<int,array>
     */
    protected function providerNestedKey(): array
    {
        return collect($this->nestedKeys())
            ->map(fn ($item, $key) => [
                'Expect argument with '.$key.' key.',
                $this->getClonedFixtureWithoutKey($key),
            ])
            ->all();
    }

    private function getClonedFixtureWithoutKey($key): array
    {
        $clone = clone_array($this->nestedKeys());
        unset($clone[$key]);

        return $clone;
    }
}
