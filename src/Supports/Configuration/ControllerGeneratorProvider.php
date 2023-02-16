<?php

namespace Typedin\LaravelCalendly\Supports\Configuration;

use Illuminate\Support\Str;
use Typedin\LaravelCalendly\Supports\EndpointMapper;

class ControllerGeneratorProvider
{
    public function __construct(public readonly EndpointMapper $mapper, public readonly string $path)
    {
    }

    public function controllerName(): string
    {
        return sprintf('Calendly%sController', $this->mapper::fullname($this->path));
    }

    public function controllerNameWithNamespace(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Controllers\%s', $this->controllerName());
    }

    public function indexFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Index%sRequest', $this->mapper::fullname($this->path));
    }

    public function showFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Show%sRequest', Str::singular($this->mapper::fullname($this->path)));
    }

    public function createFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Store%sRequest', Str::singular($this->mapper::fullname($this->path)));
    }

    public function destroyFormRequest(): string
    {
        return sprintf('\Typedin\LaravelCalendly\Http\Requests\Destroy%sRequest', Str::singular($this->mapper::fullname($this->path)));
    }

    public function model(string $method): string
    {
        // edge case not covered by the doc
        if ($this->path == '/scheduling_links') {
            return 'BookingUrl';
        }

        if ($method == 'index') {
            $local = explode('/', (string) $this->mapper->paths()->get($this->path)['get']['responses']['200']['content']['application/json']['schema']['properties']['collection']['items']['$ref']);

            return end($local);
        }

        if ($method == 'show') {
            $local = explode('/', (string) $this->mapper->paths()->get($this->path)['get']['responses']['200']['content']['application/json']['schema']['properties']['resource']['$ref']);

            return end($local);
        }

        if ($method == 'create') {
            $local = explode('/', (string) $this->mapper->paths()->get($this->path)['post']['responses']['201']['content']['application/json']['schema']['properties']['resource']['$ref']);

            return end($local);
        }

        // default to a non existing Schema
        return Str::singular($this->mapper::fullname($this->path));
    }
}
