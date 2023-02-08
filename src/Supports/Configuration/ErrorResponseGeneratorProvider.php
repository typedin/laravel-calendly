<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Illuminate\Support\Str;

class ErrorResponseGeneratorProvider extends BaseErrorResponseGeneratorProvider
{
    public function __construct(public readonly string $name, public readonly array $schema, public readonly int $error_code)
    {
    }

    public function returnType(): string
    {
        return Str::ucfirst(Str::camel(Str::lower($this->name)));
    }

    public function properties(): array
    {
        return $this->schema['properties'];
    }

    public function isNullable(string $property_name): bool
    {
        return false;
    }
}
