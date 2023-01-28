<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class IndexModelGeneratorProvider extends ModelGeneratorProvider
{
    /**
     * @param  array<int,mixed>  $value
     * @param  array<int,mixed>  $components
     */
    public function __construct(public string $path, public string $name, public array $value, public array $components)
    {
    }

    public function httpMethod(): string
    {
        return 'get';
    }

    /**
     * @return array
     */
    public function parameters(): array
    {
        return $this->value['get']['parameters'] ?? [];
    }

    public function returnType(): string
    {
        $ref = $this->value['get']['responses']['200']['content']['application/json']['schema']['properties']['collection']['items']['$ref']
                ?? $this->value['get']['responses']['200']['content']['application/json']['schema']['properties']['resource']['$ref'];
        $lookup = explode('/', $ref);

        return end($lookup);
    }

    public function schema(): array
    {
        return $this->components['schemas'][$this->returnType()];
    }

    public function schemas(): array
    {
        return $this->components['schemas'];
    }
}
