<?php

namespace Typedin\LaravelCalendly\Actions;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Typedin\LaravelCalendly\Supports\ControllerGenerator;
use Typedin\LaravelCalendly\Supports\EndpointMapper;
use Typedin\LaravelCalendly\Supports\EntityGenerator;

class GeneratedFileManager
{
    public function __construct(private readonly EndpointMapper $mapper, private readonly string $path)
    {
    }

    private static function write(string $path, ClassType $class, PhpNamespace $namespace): void
    {
        if (! is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $content = '<?php'.PHP_EOL."\n";
        $content .= $namespace;
        $content .= $class->__toString();
        // the @ suppresses the warning
        $return_value = @file_put_contents($path.$class->getName().'.php', $content);
        if (! $return_value) {
            throw new \Exception(sprintf('Could not write file (%s) in folder: %s', $class->getName().'.php', $path));
        }
    }

    public function writeEntities()
    {
        $this->mapper->entityNames()->each(function ($key) {
            $entity = ( new EntityGenerator($key, $this->mapper->schemas()->get($key)) )->entity;
            $namespace = new PhpNamespace(name: "Typedin\LaravelCalendly\Entities\\".$entity->getName());
            self::write($this->path.'Entities/', $entity, $namespace);
        });
    }

    public function writeControllers()
    {
        $this->mapper->controllerNames()->each(function ($key) {
            $controller = ( new ControllerGenerator($key, $this->mapper->mapControllerNamesToEndpoints()->get($key)->all()) )->controller;
            $namespace = new PhpNamespace(name: "Typedin\LaravelCalendly\Http\Controllers\\".$controller->getName());
            self::write($this->path.'/Http/Controllers/', $controller, $namespace);
        });
    }
}
