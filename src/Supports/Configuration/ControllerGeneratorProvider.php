<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

class ControllerGeneratorProvider
{
    /**
     * @param  array<int,mixed>  $value
     */
    public function __construct(public string $name, public array $endpoints)
    {
    }
}
