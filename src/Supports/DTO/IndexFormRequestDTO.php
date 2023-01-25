<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class IndexFormRequestDTO extends FormRequestDTO
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
        return $this->value[$this->httpMethod()]['parameters'];
    }
}
