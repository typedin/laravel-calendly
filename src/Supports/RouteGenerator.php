<?php

namespace Typedin\LaravelCalendly\Supports;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Typedin\LaravelCalendly\Supports\Configuration\RouteGeneratorProvider;

class RouteGenerator
{
    private function __construct(private readonly EndpointMapper $mapper, private readonly string $path)
    {
    }

    public static function fromPath(EndpointMapper $mapper, string $path): Collection
    {
        $generator = new RouteGenerator($mapper, $path);

        return $generator->controllerProviderForCurrentPath()->flatMap(
            fn (RouteGeneratorProvider $provider) => $generator->buildRoutes($provider)
        );
    }

    private function controllerProviderForCurrentPath(): Collection
    {
        $local_controller_provider_for_path = $this->mapper->routeGeneratorProviders()
                ->filter(function (RouteGeneratorProvider $provider) {
                    return $provider->path == $this->path;
                });

        if ($local_controller_provider_for_path->count() === 0) {
            throw new Exception("The path ( $this->path ) was not found.");
        }

        return $local_controller_provider_for_path;
    }

    private function buildRoutes(RouteGeneratorProvider $provider): Collection
    {
        return collect(array_keys($provider->mapper->paths()->get($this->path)))
            ->filter(fn ($method) => $method != 'parameters')
            ->map(fn ($method) => $this->generateFunction($method, $provider));
    }

    private function generateFunction(string $method, RouteGeneratorProvider $provider): string
    {
        $restfull_method = HttpMethod::getRestfulControllerMethod($provider->mapper->paths()->all(), $this->path, $method);

        return sprintf('Route::%s("%s", [%s::class, "%s"])', $method, $this->buildURI($restfull_method), $provider->controllerNameWithNamespace(), $restfull_method);
    }

    private function buildURI(string $restfull_method): string
    {
        $is_plural = $restfull_method == 'index';
        $local = explode('/', $this->path);

        $applesauce = collect();
        foreach ($local as $i => $singleLocal) {
            // trim UUID
            if ((str_contains($singleLocal, '{') && str_contains($singleLocal, '{'))) {
                continue;
            }
            // plural for last part of uri
            $is_plural && $i == (count($local) - 1)
                ? $applesauce->push(Str::plural($singleLocal))
                : $applesauce->push(Str::singular($singleLocal));
        }

        return $applesauce->implode('/');
    }
}
