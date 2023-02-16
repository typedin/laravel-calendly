<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Throwable;
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
        $this->controller->setExtends('\\' . Controller::class);
        $this->controller
                ->addMethod('__construct')
                ->addBody('$this->api = $api;')
                ->addParameter('api')
                ->setType('\\' . CalendlyApiInterface::class);
        $this->controller->addProperty('api')
                ->setPrivate()
                ->setType('\\' . CalendlyApiInterface::class);

        return $this;
    }

    private function generateMethods(): ControllerGenerator
    {
        try {
            collect($this->provider->mapper->paths()->get($this->provider->path))
                ->keys()
                ->each(function ($value) {
                    if (HttpMethod::hasIndex($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addIndexMethod();
                    }
                    if (HttpMethod::hasShow($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addShowMethod();
                    }
                    if (HttpMethod::hasCreate($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addCreateMethod();
                    }
                    if (HttpMethod::hasCreateWithNoContent($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addCreateMethodWithNoContent();
                    }
                    if (HttpMethod::hasDestroy($this->provider->mapper->paths()->get($this->provider->path))) {
                        $this->addDestroyMethod();
                    }
                });
        } catch (Throwable) {
            //throw $th;
        }

        return $this;
    }

    private function addIndexMethod(): void
    {
        $this->controller
            ->addMethod('index')
            ->setReturnType('\\' . JsonResponse::class)
            ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri()))
            ->addBody($this->createErrorBody())
            ->addBody('$all = collect($response->collect("collection"))')
            ->addBody(sprintf('->map(fn ($args) => new \Typedin\LaravelCalendly\Models\%s(...$args));', $this->provider->model('index')))
            ->addBody('$pagination = new \Typedin\LaravelCalendly\Models\Pagination(...$response->collect("pagination")->all());')
            ->addBody('return response()->json([')
            ->addBody(sprintf('"%s" => $all,', Str::snake(Str::plural($this->provider->model('index')))))
            ->addBody('"pagination" => $pagination,')
            ->addBody(']);')
            ->addParameter('request')
            ->setType($this->provider->indexFormRequest());
    }

    private function addShowMethod(): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
            ->addMethod('show')
            ->setReturnType('\\' . JsonResponse::class)
            ->addBody(sprintf('$response = $this->api->get("/%s/", $request);', $this->buildUri()))
            ->addBody($this->createErrorBody())
            ->addBody('return response()->json([')
            ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Models\%s(...$response->json("resource")),', Str::snake($this->provider->model('show')), $this->provider->model('show')))
            ->addBody(']);')
            ->addParameter('request')
            ->setType($this->provider->showFormRequest());
    }

    private function addCreateMethod(): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
                ->addMethod('create')
                ->setReturnType('\\' . JsonResponse::class)
                ->addBody(sprintf('$response = $this->api->post("/%s/", $request);', $this->buildUri()))
                ->addBody($this->createErrorBody())
                ->addBody('return response()->json([')
                ->addBody(sprintf('"%s" => new \Typedin\LaravelCalendly\Models\%s(...$response->json("resource")),', Str::snake($this->provider->model('create')), $this->provider->model('create')))
                ->addBody(']);')
                ->addParameter('request')
                ->setType($this->provider->createFormRequest());
    }

    private function addCreateMethodWithNoContent(): void
    {
        $this->controller
                ->addMethod('create')
                ->setReturnType('\\' . JsonResponse::class)
                ->addBody(sprintf('$response = $this->api->post("/%s/", $request);', $this->buildUri()))
                ->addBody($this->createErrorBody())
                ->addBody('return \Illuminate\Support\Facades\Response::json([], 202);')
                ->addParameter('request')
                ->setType($this->provider->createFormRequest());
    }

    private function addDestroyMethod(): void
    {
        // show method for /users/me would add twice the same method
        $this->controller
            ->addMethod('destroy')
            ->setReturnType('\\' . JsonResponse::class)
            ->addBody(sprintf('$response = $this->api->delete("/%s/");', $this->buildUri()))
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
