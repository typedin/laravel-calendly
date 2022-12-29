<?php

namespace Typedin\LaravelCalendly\Supports;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

class EntityGenerator
{
    public ClassType $entity;

    public function __construct(private readonly string $name, private array $schema)
    {
        $this->entity = new ClassType(
            sprintf('Calendly%s', $this->name),
            new PhpNamespace(sprintf('Typedin\LaravelCalendly\Entities\Calendly%s', $this->name))
        );

        $this->generateConstructor()->generateProperties();

        $this->entity->validate();
    }

    /**
     * @return ControllerGenerator
     */
    private function generateConstructor(): EntityGenerator
    {
        $this->entity->addMethod('__construct');
        if (! isset($this->schema['required'])) {
            return $this;
        }
        collect($this->schema['required'])->each(function ($required_parameter) {
            $this->entity
                    ->getMethod('__construct')
                    ->addParameter($required_parameter)
                    ->setNullable($this->isNullable($required_parameter))
                    ->setType($this->getParameterType($required_parameter));

            $this->entity->getMethod('__construct')->addBody(sprintf('$this->%s = $%s;', $required_parameter, $required_parameter));
        });

        return $this;
    }

    private function generateProperties(): EntityGenerator
    {
        if (! isset($this->schema['required'])) {
            return $this;
        }
        collect($this->schema['required'])->each(function ($required_parameter) {
            $this->entity
                    ->addProperty($required_parameter)
                    ->setType($this->getParameterType($required_parameter))
                    ->addComment($this->generatePropertieDescription($required_parameter))
                    ->addComment($this->generateVarComment($required_parameter));
        });

        return $this;
    }

    private function isNullable($required_parameter): bool
    {
        return isset($this->schema['properties'][$required_parameter]['nullable']) && $this->schema['properties'][$required_parameter]['nullable'] == true;
    }

    private function getParameterType($required_parameter): string
    {
        if (! isset($this->schema['properties'][$required_parameter]['type'])) {
            return '';
        }
        if (str_contains((string) $this->schema['properties'][$required_parameter]['type'], 'bool')) {
            return 'bool';
        }

        return $this->schema['properties'][$required_parameter]['type'] ?? '';
    }

    private function generatePropertieDescription($required_parameter): string
    {
        return $this->schema['properties'][$required_parameter]['description'] ?? '';
    }

    private function generateVarComment($required_parameter): string
    {
        if (isset($this->schema['properties'][$required_parameter]['enum'])) {
            $enum = '<'.implode('|', $this->schema['properties'][$required_parameter]['enum']).'>';

            return sprintf('@var %s $%s', $this->schema['properties'][$required_parameter]['type'].$enum, $required_parameter);
        }
        if ($this->isNullable($required_parameter)) {
            return sprintf('@var %s $%s', $this->schema['properties'][$required_parameter]['type'].'|null', $required_parameter);
        }
        if (isset($this->schema['properties'][$required_parameter]['type'])) {
            return sprintf('@var %s $%s', $this->schema['properties'][$required_parameter]['type'], $required_parameter);
        }

        return '';
    }
}
