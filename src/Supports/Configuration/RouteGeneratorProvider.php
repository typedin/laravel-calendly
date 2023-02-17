<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Typedin\LaravelCalendly\Supports\EndpointMapper;

class RouteGeneratorProvider
{
    public function __construct(public readonly string $path, public readonly EndpointMapper $mapper, public readonly string $controller_name)
    {
    }

    public function controllerName(): string
    {
        return sprintf('Calendly%sController', $this->controller_name);
    }

    public function controllerNameWithNamespace(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Controllers\%s', $this->controllerName());
    }
}
