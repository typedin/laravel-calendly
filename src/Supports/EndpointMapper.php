<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Yaml\Yaml;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\DestroyFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ErrorResponseGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\IndexFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ShowFormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\StoreFormRequestProvider;

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
        return collect($this->schemas())->keys()->filter(fn ($key) => $key !== 'ErrorResponse');
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
    public function modelProviders(): Collection
    {
        return $this->schemas()
                    ->filter(function ($value, $key) {
                        return $key !== 'ErrorResponse';
                    })
                   ->map(function ($schema, $name) {
                       try {
                           return new ModelGeneratorProvider(name: $name, schema: $schema);
                       } catch (\Throwable $th) {
                           throw new \Exception('Error Processing Data to buld a ModelGeneratorProvider');
                       }
                   });
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function formRequestProviders(): Collection
    {
        return $this->paths()
                   ->flatMap(function ($value, $path) {
                       $local = collect([]);
                       if ($path == '/users/{uuid}') {
                           $local->push(new ShowFormRequestProvider(value: $value, path: $path, name: self::fullname($path)));

                           return $local;
                       }
                       if (isset($value['get'])) {
                           if (! (isset($value['parameters']) && ! empty($value['parameters']))) {
                               $local->push(new IndexFormRequestProvider(value: $value, path: $path, name: self::fullname($path)));

                               /* return new IndexFormRequestProvider(value: $value, path: $path, name: self::fullname($path)); */
                           } else {
                               $local->push(new ShowFormRequestProvider(value: $value, path: $path, name: self::fullname($path)));
                           }
                       }
                       if (isset($value['post'])) {
                           $local->push(new StoreFormRequestProvider(value: $value, path: $path, name: self::fullname($path)));

                           /* return new StoreFormRequestProvider(value: $value, path: $path, name: self::fullname($path)); */
                       }
                       if (isset($value['delete'])) {
                           $local->push(new DestroyFormRequestProvider(value: $value, path: $path, name: self::fullname($path)));

                           /* return new DestroyFormRequestProvider(value: $value, path: $path, name: self::fullname($path)); */
                       }

                       return $local;
                   });
    }

    /**
     * @return Collection<TKey,TValue>
     */
    public function controllerGeneratorProviders(): Collection
    {
        return $this->mapControllerNamesToEndpoints()
                   ->map(function ($value, $key) {
                       return new ControllerGeneratorProvider($key, $value->all(), $this);
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

  public function errorCodes(): Collection
  {
      return  collect($this->paths()->first()['get']['responses'])->filter(function ($value, $key) {
          return $key !== 200 && isset($value['$ref']);
      })->map(function ($value) {
          $local = explode('/', $value['$ref']);

          return end($local);
      })->flip();
  }

    public function errorResponseProviders(): Collection
    {
        $base_error = ['ERROR_RESPONSE' => $this->schemas()->get('ErrorResponse')];
        $merged = collect($this->components()->get('responses'))->merge(collect($base_error));

        return $merged->map(function ($value, $key) {
            return new ErrorResponseGeneratorProvider(name: $key, schema: $value, error_code: $this->errorCodes()->get($key) ?? 500);
        });
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

    private function components(): Collection
    {
        return collect($this->parsed['components']);
    }
}
