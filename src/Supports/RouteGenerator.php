<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;

class RouteGenerator
{
    private function __construct(private  readonly EndpointMapper $mapper, private readonly string $path)
    {
    }

    public static function fromPath(EndpointMapper $mapper, string $path): Collection
    {
        $generator = new RouteGenerator($mapper, $path);

        return $generator->controllerProviderForPath()->flatMap(fn (ControllerGeneratorProvider $provider) => $generator->buildRoutes($provider)
        );
    }

    private function controllerProviderForPath(): Collection
    {
        return $this->mapper->controllerGeneratorProviders()->filter(fn (ControllerGeneratorProvider $provider) => in_array($this->path, array_keys($provider->endpoints)));
    }

    private function buildRoutes($provider): Collection
    {
        return collect(array_keys($provider->endpoints[$this->path]))
            ->map(fn ($method) => sprintf('Route::%s("%s", [%s::class, "show"])', $method, $this->path, $provider->controllerName()));
    }
}
