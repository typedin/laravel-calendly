<?php

namespace Typedin\LaravelCalendly\Supports\DTO;

abstract class FormRequestDTO
{
    /**
     * @param  array<int,mixed>  $value
     */
    public function __construct(public string $path, public string $name, public array $value)
    {
    }

    abstract public function httpMethod(): string;

    /**
     * @return array<string,string>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            $this->path => [
                $this->httpMethod() => [

                    ...$this->value,
                ],
            ],

        ];
    }
}
