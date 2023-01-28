<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class ShowModelGeneratorProvider extends ModelGeneratorProvider
{
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
        $ref = $this->value['get']['responses']['200']['content']['application/json']['schema']['properties']['resource']['$ref'] ??
                $this->value['get']['responses']['200']['content']['application/json']['schema']['properties']['collection']['items']['$ref'];
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
