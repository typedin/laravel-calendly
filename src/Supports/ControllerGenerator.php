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
        $this->controller = new ClassType(sprintf('Calendly%sController', $this->name), new PhpNamespace(sprintf('Typedin\LaravelCalendly\Http\Controllers\Calendly%sController', $this->name)));

        $this->controller
                ->setExtends(\App\Http\Controllers\Controller::class);
        $this
            ->generateConstructor()
            ->generateMethods();
    }

    private function generateConstructor()
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
    private function generateMethods()
    {
        collect($this->endpoints)
            ->filter(function ($value, $key) {
                return EndpointMapper::fullname($key) == $this->name;
            })
            ->each(function ($value, $key) {
                $this->addShowMethod($value, $key);
            });

        return $this;
    }

    private function getResponseType(array $value): string
    {
        return $value['get']['responses']['200']['content']['application/json']['schema']['type'];
    }

    private function isGetRestVerb(array $value)
    {
        return  array_key_first($value) == 'get' && $this->getResponseType($value) == 'object';
    }

    private function addShowMethod($value)
    {
        if (! $this->isGetRestVerb($value)) {
            return;
        }

        try {
            $this->controller
                    ->addMethod('show')
                    ->addBody(sprintf('$this->api->get("/users/{%s}");', '$uuid'))
                    ->addParameter('request')
                    ->setType(sprintf('\Typedin\LaravelCalendly\Http\Get%sRequest', Str::singular($this->name)));
        } catch (\Throwable $th) {
            // method show exists
        }
    }
}
