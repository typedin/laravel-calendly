<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class ModelGeneratorProvider
{
    /**
     * @param  array<int,mixed>  $schema
     */
    public function __construct(public readonly string $name, public readonly array $schema)
    {
    }

    public function getRef(string $property): string
    {
        if (! isset($this->schema()['properties'][$property]['$ref'])) {
            return '';
        }

        return $this->schema()['properties'][$property]['$ref'];
    }

    public function returnType(): string
    {
        return $this->name;
    }

    public function schema(): array
    {
        return $this->schema;
    }

    public function properties(): array
    {
        return $this->schema()['properties'] ?? [];
    }
}
