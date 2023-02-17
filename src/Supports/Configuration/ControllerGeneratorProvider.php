<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorProvider
{
    public function __construct(public readonly EndpointMapper $mapper, public string $controller_name, public Collection $paths)
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

    public function indexFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Index%sRequest', $this->controller_name);
    }

    public function showFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Show%sRequest', Str::singular($this->controller_name));
    }

    public function createFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Store%sRequest', Str::singular($this->controller_name));
    }

    public function destroyFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Destroy%sRequest', Str::singular($this->controller_name));
    }

    public function model(string $path, string $method): string
    {
        // edge case not covered by the doc
        if ($path == '/scheduling_links') {
            return 'BookingUrl';
        }

        if ($method == 'index') {
            $local = explode('/', (string) $this->paths->get($path)['get']['responses']['200']['content']['application/json']['schema']['properties']['collection']['items']['$ref']);

            return end($local);
        }

        if ($method == 'show') {
            $local = explode('/', (string) $this->paths->get($path)['get']['responses']['200']['content']['application/json']['schema']['properties']['resource']['$ref']);

            return end($local);
        }

        if ($method == 'create') {
            $local = explode('/', (string) $this->paths->get($path)['post']['responses']['201']['content']['application/json']['schema']['properties']['resource']['$ref']);

            return end($local);
        }

        // default to a non existing Schema
        return dd('handle exception here');
    }
}
