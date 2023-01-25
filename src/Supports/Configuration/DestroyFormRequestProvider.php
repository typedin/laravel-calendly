<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class DestroyFormRequestProvider extends FormRequestProvider
{
    public function httpMethod(): string
    {
        return 'delete';
    }

    public function parameters(): array
    {
        return $this->value['parameters'];
    }
}
