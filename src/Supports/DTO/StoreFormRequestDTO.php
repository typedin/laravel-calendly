<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class StoreFormRequestDTO extends FormRequestDTO
{
    public function httpMethod(): string
    {
        return 'post';
    }

    public function parameters(): array
    {
        return $this->value['parameters'];
    }

    public function requestBody(): array
    {
        return $this->value['post']['requestBody']['content'];
    }
}
