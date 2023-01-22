<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Throwable;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
use Typedin\LaravelCalendly\traits\UseCrudVerbs;

class ControllerGenerator
{
    use UseCrudVerbs;

    public ClassType $controller;

    /**
     * @param  array<int,mixed>  $endpoints
     */
    public function __construct(private readonly string $name, private readonly array $endpoints)
    {
        $this->controller = new ClassType(
            sprintf('Calendly%sController', $this->name),
        );

        $this->controller->setExtends('\\'.Controller::class);

        $this->generateConstructor()->generateMethods();

        $this->controller->validate();
    }

    private function generateConstructor(): ControllerGenerator
    {
        $this->controller
                ->addMethod('__construct')
                ->addBody('$this->api = $api;')
                ->addParameter('api')
                ->setType(CalendlyApiInterface::class);
        $this->controller->addProperty('api')
                ->setPrivate()
                ->setType(CalendlyApiInterface::class);

        return $this;
    }

    /**
     * Index Show Create Store Edit Update Destroy
     */
    private function generateMethods(): ControllerGenerator
    {
        collect($this->endpoints)
            ->each(function ($value, $key) {
                if ($this->hasIndexRestVerb($value)) {
                    $this->addIndexMethod($key);
                }
                if ($this->hasGetRestVerb($value)) {
                    $this->addShowMethod($key);
                }
                if ($this->hasPostRestVerb($value)) {
                    $this->addCreateMethod($key);
                }
                if ($this->hasDeleteRestVerb($value)) {
                    $this->addDestroyMethod($key);
                }
            });

        return $this;
    }

    private function verb(string $http_method): string
    {
        return $this->CRUD_OPERATIONS[$http_method];
    }

    private function addIndexMethod(mixed $key): void
    {
        try {
            $this->controller
                    ->addMethod('index')
                    ->setReturnType(JsonResponse::class)
                    ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri($key)))
                    ->addBody('')
                    ->addBody('$all = collect($response["collection"])')
                    ->addBody(sprintf('->mapInto(\Typedin\LaravelCalendly\Entities\Calendly%s::class)->all();', Str::singular($this->name)))
                    ->addBody('return response()->json([')
                    ->addBody(sprintf('"%s" => $all,', Str::snake($this->name)))
                    ->addBody(']);')
                    ->addParameter('request')
                    ->setType(sprintf('Typedin\LaravelCalendly\Http\Requests\%s%sRequest', $this->verb('index'), Str::plural($this->name)));
        } catch (Throwable) {
            //throw $th;
        }
    }

    private function addShowMethod(mixed $key): void
    {
        // show method for /users/me would add twice the same method
        try {
            $this->controller
                    ->addMethod('show')
                    ->setReturnType(JsonResponse::class)
                    ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri($key)))
                    ->addBody('return response()->json([')
                    ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Entities\Calendly%s($response),', Str::snake(Str::singular($this->name)), Str::singular($this->name)))
                    ->addBody(']);')
                    ->addParameter('request')
                    ->setType(sprintf('Typedin\LaravelCalendly\Http\Requests\%s%sRequest', $this->verb('get'), Str::singular($this->name)));
        } catch (Throwable) {
            //throw $th;
        }
    }

    private function addCreateMethod(mixed $key): void
    {
        $this->controller
                ->addMethod('create')
                ->setReturnType(JsonResponse::class)
                ->addBody(sprintf('$response = $this->api->post("/%s/", $request);', $this->buildUri($key)))
                ->addBody('return response()->json([')
                ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Entities\Calendly%s($response),', Str::snake(Str::singular($this->name)), Str::singular($this->name)))
                ->addBody(']);')
                ->addParameter('request')
                ->setType(sprintf('\Typedin\LaravelCalendly\Http\Requests\%s%sRequest', $this->verb('post'), Str::singular($this->name)));
    }

    private function addDestroyMethod(mixed $key): void
    {
        $this->controller
                ->addMethod('destroy')
                ->setReturnType(JsonResponse::class)
                ->addBody(sprintf('$this->api->delete("/%s/");', $this->buildUri($key)))
                ->addBody('return response()->noContent();')
                ->addParameter('request')
                ->setType(sprintf('\Typedin\LaravelCalendly\Http\Requests\%s%sRequest', $this->verb('delete'), Str::singular($this->name)));
    }

    /**
     * @param  array<int,mixed>  $value
     */
    private function getResponseType(array $value): array
    {
        return $value['get']['responses']['200']['content']['application/json']['schema']['properties'];
    }

    private function hasIndexRestVerb(mixed $value): bool
    {
        return  array_key_first($value) == 'get' && array_key_exists('collection', $this->getResponseType($value));
    }

    /**
     * @param  array<int,mixed>  $value
     */
    private function hasGetRestVerb(array $value): bool
    {
        return  array_key_exists('get', $value) && array_key_exists('resource', $this->getResponseType($value));
    }

    /**
     * @param  array<int,mixed>  $value
     */
    private function hasPostRestVerb(array $value): bool
    {
        return  array_key_exists('post', $value);
    }

    private function hasDeleteRestVerb(mixed $value): bool
    {
        return  array_key_exists('delete', $value);
    }

    private function buildUri(mixed $key): string
    {
        return collect(explode('/', (string) $key))
        // remove empty string
        ->filter(fn ($value) => (bool) $value)->map(function ($value) {
            if (strstr($value, 'uuid')) {
                $value = str_replace_first('{', '', $value);
                $value = str_replace_first('}', '', $value);

                return sprintf('{$%s}', $value);
            }

            return $value;
        })->implode('/');
    }
}
