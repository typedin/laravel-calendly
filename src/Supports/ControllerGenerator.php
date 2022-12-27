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
        $this->controller
                ->setExtends(\App\Http\Controllers\Controller::class);
        $this
            ->generateConstructor()
            ->generateMethods();
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
                $this->addIndexMethod($value, $key);
                $this->addShowMethod($value, $key);
                $this->addCreateMethod($value, $key);
                $this->addDestroyMethod($value, $key);
            });

        return $this;
    }

    private function getResponseType(array $value): array
    {
        return $value['get']['responses']['200']['content']['application/json']['schema']['properties'];
    }

    /**
     * @return bool
     */
    private function isIndexRestVerb($value): bool
    {
        return  array_key_first($value) == 'get' && array_key_exists('collection', $this->getResponseType($value));
    }

    /**
     * @return bool
     */
    private function isGetRestVerb(array $value): bool
    {
        return  array_key_exists('get', $value) && array_key_exists('resource', $this->getResponseType($value));
    }

    /**
     * @return bool
     */
    private function isPostRestVerb(array $value): bool
    {
        return  array_key_exists('post', $value);
    }

    /**
     * @return bool
     */
    private function isDeleteRestVerb($value): bool
    {
        return  array_key_exists('delete', $value);
    }

    /**
     * @return void
     */
    private function addIndexMethod($value, $key): void
    {
        if (! $this->isIndexRestVerb($value)) {
            return;
        }
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
        if (! $this->isGetRestVerb($value)) {
            return;
        }

        // remove empty string
        // reindex the array starting at 0
        $uri = explode('/', $key)[1];
        try {
            $this->controller
                    ->addMethod('show')
                    ->addBody(sprintf('$this->api->get("/%s/{%s}");', $uri, '$uuid'))
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Get%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }

    private function addCreateMethod($value, $key): void
    {
        if (! $this->isPostRestVerb($value)) {
            return;
        }
        // remove empty string
        // reindex the array starting at 0
        $uri = explode('/', $key)[1];
        try {
            $this->controller
                    ->addMethod('post')
                    ->addBody(sprintf('$this->api->post("/%s/");', $uri))
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
        if (! $this->isDeleteRestVerb($value)) {
            return;
        }
        $uri = explode('/', $key)[1];
        try {
            $this->controller
                    ->addMethod('destroy')
                    ->addBody(sprintf('$this->api->delete("/%s/");', $uri))
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Delete%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }
}
