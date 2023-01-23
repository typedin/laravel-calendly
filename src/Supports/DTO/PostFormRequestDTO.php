<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

class PostFormRequestDTO extends FormRequestDTO
{
    public function httpMethod(): string
    {
        return 'post';
    }
}
