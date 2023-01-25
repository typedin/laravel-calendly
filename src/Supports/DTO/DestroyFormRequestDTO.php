<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class DestroyFormRequestDTO extends FormRequestDTO
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
