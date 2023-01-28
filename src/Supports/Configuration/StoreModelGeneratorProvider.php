<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class StoreModelGeneratorProvider extends ModelGeneratorProvider
{
    public function httpMethod(): string
    {
        return 'post';
    }

    public function returnType(): string
    {
        $lookup = explode('/', $this->value['post']['responses']['201']['content']['application/json']['schema']['properties']['resource']['$ref']);

        return end($lookup);
    }

    public function schema(): array
    {
        return $this->components['schemas'][$this->returnType()];
    }

    public function schemas(): array
    {
        return [];
    }
}
