<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class DeleteFormRequestDTO extends FormRequestDTO
{
    public function httpMethod(): string
    {
        return 'delete';
    }
}
