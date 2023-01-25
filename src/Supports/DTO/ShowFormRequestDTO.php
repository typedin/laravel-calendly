<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class ShowFormRequestDTO extends FormRequestDTO
{
    public function httpMethod(): string
    {
        return 'get';
    }

    public function parameters(): array
    {
        return $this->value['parameters'];
    }
}
