<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

abstract class FormRequestProvider
{
    public function __construct(public string $path, public string $name, public array $value)
    {
    }

    abstract public function httpMethod(): string;

    abstract public function parameters(): array;

    public function requestBody(): array
    {
        return [];
    }

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
