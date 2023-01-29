<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class BaseErrorResponseGeneratorProvider
{
    /**
     * @param  array<int,mixed>  $schema
     */
    public function __construct(public readonly array $schema)
    {
    }

    public function returnType(): string
    {
        return 'ErrorResponse';
    }

    public function properties(): array
    {
        return $this->schema['properties'];
    }

    public function isNullable(string $property_name): bool
    {
        return ! in_array($property_name, $this->schema['required']);
    }
}
