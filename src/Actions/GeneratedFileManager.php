<?php

namespace Typedin\LaravelCalendly\Actions;

use Exception;
use Illuminate\Support\Collection;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\PsrPrinter;
use Throwable;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;
use Typedin\LaravelCalendly\Supports\EndpointMapper;
use Typedin\LaravelCalendly\Supports\EntityGenerator;
use Typedin\LaravelCalendly\Supports\FormRequestGenerator;

class GeneratedFileManager
{
    /**
     * @var Collection<array-key,<missing>>
     */
    public readonly Collection $entities;

    /**
     * @var Collection<array-key,<missing>>
     */
    public readonly Collection $controllers;

    /**
     * @var Collection<array-key,<missing>>
     */
    private readonly Collection $formRequests;

    public function __construct(private readonly EndpointMapper $mapper, private readonly string $path)
    {
        $this->entities = new Collection();
        $this->formRequests = new Collection();
        $this->controllers = new Collection();
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

    private static function buildSimplifiedReturnType($input): mixed
    {
        if (! $input) {
            return null;
        }

        return (string) collect(explode('\\', (string) $input))->last();
    }

    private static function replaceQualifiersWithImport(ClassType $class): ClassType
    {
        if ($extends = $class->getExtends()) {
            $class->setExtends(self::buildSimplifiedReturnType($extends));
        }
        collect($class->getMethods())->each(function ($method) {
            collect($method->getParameters())
                ->each(function ($parameter) {
                    $parameter->setType(self::buildSimplifiedReturnType($parameter->getType()));
                });
            $method->setReturnType(self::buildSimplifiedReturnType($method->getReturnType()));
        });

        if (collect($class->getProperties())->count()) {
            collect($class->getProperties())->each(function ($property) {
                $property->setType(self::buildSimplifiedReturnType($property->getType()));
            });
        }

        return $class;
    }

    public function createEntities(): GeneratedFileManager
    {
        $this->mapper->entityNames()->each(function ($key) {
            $entity = ( new EntityGenerator($key, $this->mapper->schemas()->get($key)) )->entity;

            $namespace = $this->createNamespace($entity, "Typedin\LaravelCalendly\Entities");
            $this->entities->push(['entity' => self::replaceQualifiersWithImport($entity), 'namespace' => $namespace]);
        });

        return $this;
    }

    public function createFormRequests(): GeneratedFileManager
    {
        $this->mapper->formRequestNames()->each(function ($key) {
            $schema = $this->mapper->schemas()->get($key);
            if (! isset($schema['properties'])) {
                $schema['properties'] = [];
            }
            $request = ( new FormRequestGenerator($key, $schema) )->validator;

            $namespace = $this->createNamespace($request, "Typedin\LaravelCalendly\Http\Requests");
            $this->formRequests->push(['form_request' => self::replaceQualifiersWithImport($request), 'namespace' => $namespace]);
        });

        return $this;
    }

    public function createControllers(): GeneratedFileManager
    {
        $this->mapper->controllerNames()->each(function ($key) {
            $controller = ( new ControllerGenerator($key, $this->mapper->mapControllerNamesToEndpoints()->get($key)->all()) )->controller;
            $namespace = $this->createNamespace($controller, "Typedin\LaravelCalendly\Http\Controllers");

            $this->controllers->push(['controller' => self::replaceQualifiersWithImport($controller), 'namespace' => $namespace]);
        });

        return $this;
    }

    public function writeAllFiles(): void
    {
        $this->entities->each(function ($entry) {
            self::write($this->path.'Entities/', $entry['entity'], $entry['namespace']);
        });
        $this->controllers->each(function ($entry) {
            self::write($this->path.'/Http/Controllers/', $entry['controller'], $entry['namespace']);
        });
        $this->formRequests->each(function ($entry) {
            self::write($this->path.'/Http/Requests/', $entry['form_request'], $entry['namespace']);
        });
    }

    private function createNamespace(ClassType $class, $name): PhpNamespace
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
