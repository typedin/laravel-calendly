<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class StoreFormRequestProvider extends FormRequestProvider
{
    public function httpMethod(): string
    {
        return 'post';
    }

    public function parameters(): array
    {
        return $this->value['parameters'] ?? [];
    }

    public function requestBody(): array
    {
        return $this->value['post']['requestBody']['content'] ?? [];
    }
}
