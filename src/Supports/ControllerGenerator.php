<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Typedin\LaravelCalendly\Contracts\CalendlyApiInterface;
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
        $this->controller->setExtends('\\'.Controller::class);
        $this->controller
                ->addMethod('__construct')
                ->addBody('$this->api = $api;')
                ->addParameter('api')
                ->setType('\\'.CalendlyApiInterface::class);
        $this->controller->addProperty('api')
                ->setPrivate()
                ->setType('\\'.CalendlyApiInterface::class);

        return $this;
    }

    private function generateMethods(): ControllerGenerator
    {
        $this->provider->paths
        ->each(function ($value, $path) {
            if (HttpMethod::hasIndex($value)) {
                $this->addIndexMethod($path);
            }
            if (HttpMethod::hasShow($value)) {
                $this->addShowMethod($path);
            }
            if (HttpMethod::hasCreate($value)) {
                $this->addCreateMethod($path);
            }
            if (HttpMethod::hasCreateWithNoContent($value)) {
                $this->addCreateMethodWithNoContent($path);
            }
            if (HttpMethod::hasDestroy($value)) {
                $this->addDestroyMethod($path);
            }
        });

        return $this;
    }

    private function addIndexMethod(string $path): void
    {
        $this->controller
            ->addMethod('index')
            ->setReturnType('\\'.JsonResponse::class)
            ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri($path)))
            ->addBody($this->createErrorBody())
            ->addBody('$all = collect($response->collect("collection"))')
            ->addBody(sprintf('->map(fn ($args) => new \Typedin\LaravelCalendly\Models\%s(...$args));', $this->provider->model($path, 'index')))
            ->addBody('$pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect("pagination")->all());')
            ->addBody('return response()->json([')
            ->addBody(sprintf('"%s" => $all,', Str::snake(Str::plural($this->provider->model($path, 'index')))))
            ->addBody('"pagination" => $pagination,')
            ->addBody(']);')
            ->addParameter('request')
            ->setType($this->provider->indexFormRequest());
    }

    private function addShowMethod(string $path): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
            ->addMethod('show')
            ->setReturnType('\\'.JsonResponse::class)
            ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri($path)))
            ->addBody($this->createErrorBody())
            ->addBody('return response()->json([')
            ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Models\%s(...$response->json("resource")),', Str::snake($this->provider->model($path, 'show')), $this->provider->model($path, 'show')))
            ->addBody(']);')
            ->addParameter('request')
            ->setType($this->provider->showFormRequest());
    }

    private function addCreateMethod(string $path): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
                ->addMethod('create')
                ->setReturnType('\\'.JsonResponse::class)
                ->addBody(sprintf('$response = $this->api->post("/%s/", $request);', $this->buildUri($path)))
                ->addBody($this->createErrorBody())
                ->addBody('return response()->json([')
                ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Models\%s(...$response->json("resource")),', Str::snake($this->provider->model($path, 'create')), $this->provider->model($path, 'create')))
                ->addBody(']);')
                ->addParameter('request')
                ->setType($this->provider->createFormRequest());
    }

    private function addCreateMethodWithNoContent(string $path): void
    {
        $this->controller
                ->addMethod('create')
                ->setReturnType('\\'.JsonResponse::class)
                ->addBody(sprintf('$response = $this->api->post("/%s/", $request);', $this->buildUri($path)))
                ->addBody($this->createErrorBody())
                ->addBody('return \Illuminate\Support\Facades\Response::json([], 202);')
                ->addParameter('request')
                ->setType($this->provider->createFormRequest());
    }

    private function addDestroyMethod(string $path): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
            ->addMethod('destroy')
            ->setReturnType('\\'.JsonResponse::class)
            ->addBody(sprintf('$response = $this->api->delete("/%s/");', $this->buildUri($path)))
            ->addBody($this->createErrorBody())
            ->addBody('return \Illuminate\Support\Facades\Response::json([], 204);')
            ->addParameter('request')
            ->setType($this->provider->destroyFormRequest());
    }

    private function buildUri(string $path): string
    {
        return collect(explode('/', $path))
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
