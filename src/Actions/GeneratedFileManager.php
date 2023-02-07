<?php

namespace Typedin\LaravelCalendly\Actions;

use Exception;
use Illuminate\Support\Collection;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Throwable;
use Typedin\LaravelCalendly\Supports\Configuration\FormRequestProvider;
use Typedin\LaravelCalendly\Supports\Configuration\ModelGeneratorProvider;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;
use Typedin\LaravelCalendly\Supports\EndpointMapper;
use Typedin\LaravelCalendly\Supports\ErrorResponseGenerator;
use Typedin\LaravelCalendly\Supports\FormRequestGenerator;
use Typedin\LaravelCalendly\Supports\ModelGenerator;

class GeneratedFileManager
{
    /**
     * @var Collection<array-key,<missing>>
     */
    public readonly Collection $models;

    /**
     * @var Collection<array-key,<missing>>
     */
    public readonly Collection $errorResponses;

    /**
     * @var Collection<array-key,<missing>>
     */
    public readonly Collection $controllers;

    /**
     * @var Collection<array-key,<missing>>
     */
    public readonly Collection $formRequests;

    public function __construct(private readonly EndpointMapper $mapper, private readonly string $path)
    {
        $this->controllers = new Collection();
        $this->models = new Collection();
        $this->formRequests = new Collection();
        $this->errorResponses = new Collection();
    }

    public function createModels(): GeneratedFileManager
    {
        $this->mapper->modelProviders()->map(function (ModelGeneratorProvider $provider) {
            return ModelGenerator::model($provider);
        })->unique()->filter()->each(fn ($model) => $this->models->push([
            'model' => $model,
            'namespace' => $this->createNamespace($model, "Typedin\LaravelCalendly\Models"),
        ]));

        return $this;
    }

    public function createFormRequests(): GeneratedFileManager
    {
        $this->mapper->formRequestProviders()->each(function (FormRequestProvider $provider) {
            $request = FormRequestGenerator::formRequest($provider);
            $this->formRequests->push([
                'form_request' => $request,
                'namespace' => $this->createNamespace($request, "Typedin\LaravelCalendly\Http\Requests"),
            ]);
        });

        return $this;
    }

    public function createControllers(): GeneratedFileManager
    {
        $this->mapper->controllerGeneratorProviders()->each(function ($provider) {
            $controller = ControllerGenerator::controller($provider);

            $this->controllers->push([
                'controller' => $controller,
                'namespace' => $this->createNamespace($controller, "Typedin\LaravelCalendly\Http\Controllers"),
            ]);
        });

        return $this;
    }

    public function createErrorResponses(): GeneratedFileManager
    {
        $this->mapper->errorResponseProviders()->each(function ($provider) {
            $error_response = ErrorResponseGenerator::errorResponse($provider);
            $this->errorResponses->push([
                'error_response' => $error_response,
                'namespace' => $this->createNamespace($error_response, "Typedin\LaravelCalendly\Http\Errors"),
            ]);
        });

        return $this;
    }

    public function writeAllFiles(): void
    {
        $this->createModels()
            ->models->each(function ($entry) {
                self::write($this->path.'Models/', $entry['model'], $entry['namespace']);
            });
        $this->createControllers()
            ->controllers->each(function ($entry) {
                self::write($this->path.'/Http/Controllers/', $entry['controller'], $entry['namespace']);
            });
        $this->createFormRequests()
            ->formRequests->each(function ($entry) {
                self::write($this->path.'/Http/Requests/', $entry['form_request'], $entry['namespace']);
            });
        $this->createErrorResponses()
            ->errorResponses->each(function ($entry) {
                self::write($this->path.'/Http/Errors/', $entry['error_response'], $entry['namespace']);
            });
    }

    private static function write(string $path, ClassType $class, PhpNamespace $namespace): void
    {
        $printer = new PsrPrinter();

        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $content = '<?php'.PHP_EOL."\n";
        $content .= $namespace;
        $content .= $printer->printClass($class);
        // the @ suppresses the warning
        $return_value = @file_put_contents($path.$class->getName().'.php', $content);
        if (! $return_value) {
            throw new Exception(sprintf('Could not write file (%s) in folder: %s', $class->getName().'.php', $path));
        }
    }

    private static function replaceQualifiersWithImport(ClassType $class): ClassType
    {
        if ($extends = $class->getExtends()) {
            $class->setExtends($extends);
        }
        collect($class->getMethods())->each(function ($method) {
            collect($method->getParameters())
                ->each(function ($parameter) {
                    $parameter->setType($parameter->getType());
                });
            $method->setReturnType($method->getReturnType());
        });

        if (collect($class->getProperties())->count() !== 0) {
            collect($class->getProperties())->each(function ($property) {
                $property->setType($property->getType());
            });
        }

        return $class;
    }

    private function createNamespace(ClassType $class, string $name): PhpNamespace
    {
        $namespace = new PhpNamespace($name);
        foreach ($class->getMethods() as $method) {
            $types[] = $method->getReturnType(true);
            array_map(function ($param) use (&$types) {
                $types[] = $param->getType(true);
            }, $method->getParameters());
        }
        array_map(function ($param) use (&$types) {
            $types[] = $param->getType(true);
        }, $class->getProperties());
        if ($types) {
            foreach (array_filter($types) as $type) {
                foreach ($type->getTypes() as $subtype) {
                    if (! $subtype->isClass()) {
                        continue;
                    }
                    if ($subtype->isClassKeyword()) {
                        continue;
                    }
                    $namespace->addUse((string) $subtype);
                }
            }
        }
        foreach ($class->getImplements() as $implement) {
            $namespace->addUse($implement);
        }
        if ($class->getExtends()) {
            $namespace->addUse($class->getExtends());
        }
        // cannot add keyword as use type
        // So I rely on fail silently
        foreach ($class->getProperties() as $property) {
            try {
                $namespace->addUse((string) $property->getType());
            } catch (Throwable) {
                //throw $th;
            }
        }

        return $namespace;
    }
}
