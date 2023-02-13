<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorProvider
{
    /**
     * @param  array  $endpoints
     * @param  EndpointMapper  $mapper
     */
    public function __construct(public string $name, public array $endpoints, public readonly EndpointMapper $mapper)
    {
    }

    public function controllerName(): string
    {
        return sprintf('Calendly%sController', $this->name);
    }

    public function controllerNameWithNamespace(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Controllers\%s', $this->controllerName());
    }
}
