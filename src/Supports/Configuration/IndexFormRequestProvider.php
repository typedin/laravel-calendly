<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class IndexFormRequestProvider extends FormRequestProvider
{
    public function httpMethod(): string
    {
        return 'get';
    }

    public function parameters(): array
    {
        return $this->value['get']['parameters'] ?? [];
    }
}
