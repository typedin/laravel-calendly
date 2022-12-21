<?php

namespace Typedin\LaravelCalendly\Support;

use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class BuilderFromDoc
{
    private array $yaml;

    private function __construct(string $input)
    {
        $output = Yaml::parse($input);

        if (! $output['paths']) {
            throw new ParseException(message: 'No paths found.');
        }
        $this->yaml = $output;
    }

    /**
     * @return void
     */
    private function build(): Collection
    {
        $result = new Collection();

        foreach ($this->yaml['paths'] as $key => $value) {
            $result->push(new Thing(id: $key, data: $value));
        }

        return $result;
    }

    public static function handle($argument): Collection
    {
        return ( new BuilderFromDoc($argument) )->build();
    }
}
