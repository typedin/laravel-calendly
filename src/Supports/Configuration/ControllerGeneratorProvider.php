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

    public function model(): string
    {
        if ($this->path == '/scheduling_links') {
            return 'BookingUrl';
        }

        return Str::singular($this->mapper::fullname($this->path));
    }
}
