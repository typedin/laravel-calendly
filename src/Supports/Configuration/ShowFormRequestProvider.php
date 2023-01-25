<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class ShowFormRequestProvider extends FormRequestProvider
{
    public function httpMethod(): string
    {
        return 'get';
    }

    public function parameters(): array
    {
        return $this->value['parameters'] ?? [];
    }
}
