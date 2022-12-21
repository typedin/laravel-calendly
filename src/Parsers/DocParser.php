<?php

namespace Typedin\LaravelCalendly\Parsers;

use Illuminate\Support\Collection;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class DocParser
{
    private array $yaml;

    public function __construct(string $input)
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
    public function paths(): Collection
    {
        return collect($this->yaml['paths']);
    }
}
