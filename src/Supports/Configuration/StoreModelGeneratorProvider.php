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
        $ref = $this->value['post']['responses']['201']['content']['application/json']['schema']['properties']['resource']['$ref'] ??
                $this->value['post']['responses']['201']['content']['application/json']['schema']['properties']['resource'];
        if (is_array($ref)) {
            throw new \TypeError(message: 'return type is not in references');
        }
        $lookup = explode('/', $ref);

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
