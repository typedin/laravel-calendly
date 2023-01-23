<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class GetFormRequestDTO extends FormRequestDTO
{
    public function httpMethod(): string
    {
        return 'get';
    }
}
