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

        return $generator->controllerProviderForCurrentPath()->flatMap(fn (ControllerGeneratorProvider $provider) => $generator->buildRoutes($provider)
        );
    }

    private function controllerProviderForCurrentPath(): Collection
    {
        return $this->mapper->controllerGeneratorProviders()->filter(fn (ControllerGeneratorProvider $provider) => in_array($this->path, array_keys($provider->endpoints)));
    }

    private function buildRoutes($provider): Collection
    {
        return collect(array_keys($provider->endpoints[$this->path]))
            ->filter(fn ($method) => $method != 'parameters')
            ->map(fn ($method) => sprintf('Route::%s("%s", [%s::class, "%s"])', $method, $this->path, $provider->controllerName(), $this->getControllerMethod($provider->endpoints, $method)));
    }

    private function getControllerMethod($endpoints, $method): string
    {
        $responses = $endpoints[$this->path][$method]['responses'];
        if (in_array(200, array_keys($responses))) {
            if (array_key_exists('collection', $responses[200]['content']['application/json']['schema']['properties'])) {
                return 'index';
            }
            if (array_key_exists('resource', $responses[200]['content']['application/json']['schema']['properties'])) {
                return 'show';
            }
        }
        if (in_array(201, array_keys($responses))) {
            return 'create';
        }
        if (in_array(204, array_keys($responses))) {
            return 'destroy';
        }

        throw new \Exception('Could not determine a method for the path:'.$this->path, 1);
    }
}
