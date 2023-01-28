<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;
use TKey;
use TValue;
use Typedin\LaravelCalendly\Supports\Configuration\DestroyFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\IndexFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\IndexModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ShowFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ShowModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\StoreFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\StoreModelGeneratorProvider;

class EndpointMapper
{
    /**
     * @var mixed
     */
    private $parsed;

    public function __construct(string $yaml)
    {
        $this->parsed = Yaml::parse($yaml);
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function schemas(): Collection
    {
        return collect($this->parsed['components']['schemas']);
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function paths(): Collection
    {
        return collect($this->parsed['paths']);
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function entityNames(): Collection
    {
        return collect($this->schemas())->keys();
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function formRequestNames(): Collection
    {
        return collect($this->schemas()->keys());
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function modelConfigurators(): Collection
    {
        return $this->paths()
                   ->map(function ($value, $path) {
                       if (isset($value['get'])) {
                           if (! (isset($value['parameters']) && ! empty($value['parameters']))) {
                               return new IndexModelGeneratorProvider(value: $value, path: $path, name: self::fullname($path), components: $this->parsed['components']);
                           }

                           return new ShowModelGeneratorProvider(value: $value, path: $path, name: self::fullname($path), components: $this->parsed['components']);
                       }
                       if (isset($value['post'])) {
                           return new StoreModelGeneratorProvider(value: $value, path: $path, name: self::fullname($path), components: $this->parsed['components']);
                       }

                       throw new \Exception('Error Processing Data to buld a FormRequestDTO');
                   });
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function formRequestDTOS(): Collection
    {
        return $this->paths()
                   ->map(function ($value, $path) {
                       if (isset($value['get'])) {
                           if (! (isset($value['parameters']) && ! empty($value['parameters']))) {
                               return new IndexFormRequestProvider(value: $value, path: $path, name: self::fullname($path));
                           }

                           return new ShowFormRequestProvider(value: $value, path: $path, name: self::fullname($path));
                       }
                       if (isset($value['post'])) {
                           return new StoreFormRequestProvider(value: $value, path: $path, name: self::fullname($path));
                       }
                       if (isset($value['delete'])) {
                           return new DestroyFormRequestProvider(value: $value, path: $path, name: self::fullname($path));
                       }

                       throw new \Exception('Error Processing Data to buld a FormRequestDTO');
                   });
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function controllerNames(): Collection
    {
        return $this->paths()->keys()
                   ->map(fn ($key) => self::fullname($key))
                   ->filter(fn ($key) => (bool) $key)
                   ->unique()
                   ->values();
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function mapControllerNamesToEndpoints(): Collection
    {
        return $this->controllerNames()
                   ->flatMap(fn ($controller_name) => [
                       $controller_name => $this->paths()->filter(fn ($_value, $key) => self::fullname($key) == $controller_name),
                   ]);
    }

    public static function fullname(string $input): string
    {
        $local = collect(array_values(array_filter(explode('/', $input))))
               ->filter(fn ($part) => ! Str::contains($part, ['deletion', 'uuid']))
               ->filter(fn ($part) => $part !== 'me')
               ->values()
               ->map(fn ($part): string => ucfirst(Str::camel($part)));

        return $local->map(function ($part, $key) use ($local) {
            if ($key < count($local) - 1) {
                return  Str::singular($part);
            }

            return Str::plural($part);
        })->implode('');
    }
}
