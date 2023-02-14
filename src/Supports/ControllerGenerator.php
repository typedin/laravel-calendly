<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Throwable;
use Typedin\LaravelCalendly\Supports\Configuration\ControllerGeneratorProvider;

class ControllerGenerator
{
    public ClassType $controller;

    private function __construct(private readonly ControllerGeneratorProvider $provider)
    {
    }

    public static function controller(ControllerGeneratorProvider $provider): ClassType
    {
        $generator = new ControllerGenerator($provider);

        $generator->controller = new ClassType(name: $provider->controllerName());

        $generator->generateConstructor()->generateMethods();
        $generator->controller->validate();

        return $generator->controller;
    }

    private function generateConstructor(): ControllerGenerator
    {
        $this->controller->setExtends('\Illuminate\Routing\Controller');
        $this->controller
                ->addMethod('__construct')
                ->addBody('$this->api = $api;')
                ->addParameter('api')
                ->setType('\Typedin\LaravelCalendly\Contracts\CalendlyApiInterface');
        $this->controller->addProperty('api')
                ->setPrivate()
                ->setType('\Typedin\LaravelCalendly\Contracts\CalendlyApiInterface');

        return $this;
    }

    private function generateMethods(): ControllerGenerator
    {
        try {
            collect($this->provider->mapper->paths()->get($this->provider->path))
                ->keys()
                ->each(function ($value) {
                    if (HttpMethod::hasIndex($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addIndexMethod($value);
                    }
                    if (HttpMethod::hasShow($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addShowMethod($value);
                    }
                    if (HttpMethod::hasCreate($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addCreateMethod($value);
                    }
                    if (HttpMethod::hasDestroy($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addDestroyMethod($value);
                    }
                });
        } catch (Throwable) {
            //throw $th;
        }

        return $this;
    }

    private function addIndexMethod(mixed $key): void
    {
        $this->controller
            ->addMethod('index')
            ->setReturnType('\Illuminate\Http\JsonResponse')
            ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri($key)))
            ->addBody($this->createErrorBody())
            ->addBody('$all = collect($response->collect("collection"))')
            ->addBody(sprintf('->mapInto(\Typedin\LaravelCalendly\Models\%s::class)->all();', $this->provider->model()))
            ->addBody('$pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect("pagination")->all());')
            ->addBody('return response()->json([')
            ->addBody(sprintf('"%s" => $all,', Str::snake(Str::plural($this->provider->model()))))
            ->addBody('"pagination" => $pagination,')
            ->addBody(']);')
            ->addParameter('request')
            ->setType($this->provider->indexFormRequest());
    }

    private function addShowMethod(mixed $key): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
            ->addMethod('show')
            ->setReturnType('\Illuminate\Http\JsonResponse')
            ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri($key)))
            ->addBody($this->createErrorBody())
            ->addBody('return response()->json([')
            ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Models\%s(...$response->json("resource")),', Str::snake($this->provider->model()), $this->provider->model()))
            ->addBody(']);')
            ->addParameter('request')
            ->setType($this->provider->showFormRequest());
    }

    private function addCreateMethod(mixed $key): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
                ->addMethod('create')
                ->setReturnType('\Illuminate\Http\JsonResponse')
                ->addBody(sprintf('$response = $this->api->post("/%s/", $request);', $this->buildUri($key)))
                ->addBody($this->createErrorBody())
                ->addBody('return response()->json([')
                ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Models\%s(...$response->json("resource")),', Str::snake($this->provider->model()), $this->provider->model()))
                ->addBody(']);')
                ->addParameter('request')
                ->setType($this->provider->createFormRequest());
    }

    private function addDestroyMethod(string $key): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
            ->addMethod('destroy')
            ->setReturnType('\Illuminate\Http\JsonResponse')
            ->addBody(sprintf('$response = $this->api->delete("/%s/");', $this->buildUri($key)))
            ->addBody($this->createErrorBody())
            ->addBody('return \Illuminate\Support\Facades\Response::json([], 204);')
            ->addParameter('request')
            ->setType($this->provider->destroyFormRequest());
    }

    private function buildUri(): string
    {
        return collect(explode('/', $this->provider->path))
            // remove empty string
            ->filter(fn ($value) => (bool) $value)
            ->map(function ($value) {
                if (strstr($value, 'uuid')) {
                    $value = str_replace_first('{', '', $value);
                    $value = str_replace_first('}', '', $value);

                    return sprintf('{$request->validated("%s")}', $value);
                }

                return $value;
            })->implode('/');
    }

    private function createErrorBody(): string
    {
        return 'if(!$response->ok()) {'.'return \Typedin\LaravelCalendly\Services\ErrorResponseFactory::getJson($response);'.'}';
    }
}
