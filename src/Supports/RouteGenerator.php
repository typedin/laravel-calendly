<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;

class RouteGenerator
{
    private function __construct(private readonly EndpointMapper $mapper, private readonly string $path)
    {
    }

    public static function fromPath(EndpointMapper $mapper, string $path): Collection
    {
        $generator = new RouteGenerator($mapper, $path);

        return $generator->controllerProviderForCurrentPath()->flatMap(
            fn (ControllerGeneratorProvider $provider) => $generator->buildRoutes($provider)
        );
    }

    private function controllerProviderForCurrentPath(): Collection
    {
        $local_controller_provider_for_path = $this->mapper->controllerGeneratorProviders()->filter(fn (ControllerGeneratorProvider $provider) => $provider->path == $this->path);

        if (! $local_controller_provider_for_path->count()) {
            throw new \Exception("The path ( $this->path ) was not found.");
        }

        return $local_controller_provider_for_path;
    }

    private function buildRoutes($provider): Collection
    {
        return collect(array_keys($provider->mapper->paths()->get($this->path)))
            ->filter(fn ($method) => $method != 'parameters')
            ->map(fn ($method) => $this->generateFunction($method, $provider));
    }

    private function generateFunction(string $method, ControllerGeneratorProvider $provider): string
    {
        return sprintf('Route::%s("%s", [%s::class, "%s"])', $method, $this->path, $provider->controllerNameWithNamespace(), HttpMethod::getRestfulControllerMethod($provider->mapper->paths()->all(), $this->path, $method));
    }
}
