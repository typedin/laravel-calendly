<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorProvider
{
    /**
     * @param  array<int,mixed>  $endpoints
     * @param  mixed  $mapper
     */
    public function __construct(public string $name, public array $endpoints, public readonly EndpointMapper $mapper)
    {
    }
}
