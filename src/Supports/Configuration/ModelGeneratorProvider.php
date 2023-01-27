<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

abstract class ModelGeneratorProvider
{
    /**
     * @param  array<int,mixed>  $value
     * @param  array<int,mixed>  $components
     */
    public function __construct(public string $path, public string $name, public array $value, public array $components)
    {
    }

    abstract public function httpMethod(): string;

    abstract public function returnType(): string;

    abstract public function schema(): array;
}
