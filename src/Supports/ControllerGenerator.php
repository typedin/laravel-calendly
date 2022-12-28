<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

class ControllerGenerator
{
    public ClassType $controller;

    public function __construct(private string $name, private array $endpoints)
    {
        $this->controller = new ClassType(
            sprintf('Calendly%sController', $this->name),
            new PhpNamespace(sprintf('Typedin\LaravelCalendly\Http\Controllers\Calendly%sController', $this->name))
        );

        $this->controller->setExtends(\App\Http\Controllers\Controller::class);

        $this->generateConstructor()->generateMethods();
    }

    /**
     * @return ControllerGenerator
     */
    private function generateConstructor(): ControllerGenerator
    {
        $this->controller
                ->addMethod('__construct')
                ->addBody(sprintf('$this->api = $api;'))
                ->addParameter('api')
                ->setType(\Typedin\LaravelCalendly\Contracts\CalendlyApiInterface::class);

        return $this;
    }

    /**
     * Index
     * Show
     * Create
     * Store
     * Edit
     * Update
     * Destroy
     */
    private function generateMethods(): ControllerGenerator
    {
        collect($this->endpoints)
            ->each(function ($value, $key) {
                if ($this->hasIndexRestVerb($value)) {
                    $this->addIndexMethod($value, $key);
                }
                if ($this->hasGetRestVerb($value)) {
                    $this->addShowMethod($value, $key);
                }
                if ($this->hasPostRestVerb($value)) {
                    $this->addCreateMethod($value, $key);
                }
                if ($this->hasDeleteRestVerb($value)) {
                    $this->addDestroyMethod($value, $key);
                }
            });

        return $this;
    }

    /**
     * @return void
     */
    private function addIndexMethod($value, $key): void
    {
        // remove empty string
        // reindex the array starting at 0
        $uri = implode(array_values(array_filter(explode('/', $key))));
        try {
            $this->controller
                    ->addMethod('index')
                    ->addBody(sprintf('$this->api->get("/%s/{%s}");', $uri, '$uuid'))
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Index%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }

    /**
     * @return void
     */
    private function addShowMethod($value, $key): void
    {
        try {
            $this->controller
                    ->addMethod('show')
                    ->addBody(sprintf('$response = $this->api->get("/%s/");', $this->buildUri($key)))
                    ->addBody('return response()->json([')
                    ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Entities\%s($response),', Str::lower(Str::singular($this->name)), Str::singular($this->name)))
                    ->addBody(']);')
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Get%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }

    private function addCreateMethod($value, $key): void
    {
        try {
            $this->controller
                    ->addMethod('post')
                    ->addBody(sprintf('$this->api->post("/%s/");', $this->buildUri($key)))
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Post%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }

    /**
     * @return void
     */
    private function addDestroyMethod($value, $key): void
    {
        try {
            $this->controller
                    ->addMethod('destroy')
                    ->addBody(sprintf('$this->api->delete("/%s/");', $this->buildUri($key)))
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Delete%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }

    /**
     * @return array
     */
    private function getResponseType(array $value): array
    {
        return $value['get']['responses']['200']['content']['application/json']['schema']['properties'];
    }

    /**
     * @return bool
     */
    private function hasIndexRestVerb($value): bool
    {
        return  array_key_first($value) == 'get' && array_key_exists('collection', $this->getResponseType($value));
    }

    /**
     * @return bool
     */
    private function hasGetRestVerb(array $value): bool
    {
        return  array_key_exists('get', $value) && array_key_exists('resource', $this->getResponseType($value));
    }

    /**
     * @return bool
     */
    private function hasPostRestVerb(array $value): bool
    {
        return  array_key_exists('post', $value);
    }

    /**
     * @return bool
     */
    private function hasDeleteRestVerb($value): bool
    {
        return  array_key_exists('delete', $value);
    }

    private function buildUri($key): string
    {
        return collect(explode('/', $key))->filter(function ($value) {
            // remove empty string
            return (bool) $value;
        })->map(function ($value) {
            if (strstr($value, 'uuid')) {
                $value = str_replace_first('{', '', $value);
                $value = str_replace_first('}', '', $value);

                return sprintf('{$%s}', $value);
            }

            return $value;
        })->implode('/');
    }
}
