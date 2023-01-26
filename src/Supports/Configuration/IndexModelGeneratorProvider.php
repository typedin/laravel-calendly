<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class IndexModelGeneratorProvider
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
        $lookup = explode('/', $this->value['get']['responses']['200']['content']['application/json']['schema']['properties']['collection']['items']['$ref']);

        return $this->components['schemas'][end($lookup)]['title'];
    }
}
