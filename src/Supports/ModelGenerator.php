<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Typedin\LaravelCalendly\Supports\Configuration\ModelGeneratorProvider;

class ModelGenerator
{
    public readonly ClassType $model;

    private function __construct(private readonly ModelGeneratorProvider $provider)
    {
    }

    public static function model(ModelGeneratorProvider $provider): ClassType
    {
        $model_generator = new ModelGenerator($provider);

        $model_generator->model = new ClassType(
            name: Str::singular($model_generator->provider->returnType()),
            namespace: new PhpNamespace('Typedin\LaravelCalendly\Models')
        );

        $model_generator->generateConstructor()->generateProperties();
        $model_generator->model->validate();

        return $model_generator->model;
    }

    private function generateConstructor(): ModelGenerator
    {
        $this->model->addMethod('__construct');
        collect($this->provider->properties())->each(function ($property_value, $property_name) {
            $this->model
                    ->getMethod('__construct')
                    ->addParameter($property_name)
                    ->setNullable($this->isNullable($property_name, $property_value))
                    ->setType($this->getParameterType($property_name, $property_value));

            $this->model->getMethod('__construct')->addBody(sprintf('$this->%s = $%s;', $property_name, $property_name));
        });

        return $this;
    }

    private function generateProperties(): ModelGenerator
    {
        collect($this->provider->properties())->each(function ($property_value, $property_name) {
            $this->model
                    ->addProperty($property_name)
                    ->setType($this->getParameterType($property_name, $property_value))
                    ->setNullable($this->isNullable($property_name, $property_value))
                    ->addComment($this->generatePropertieDescription($property_name, $property_value))
                    ->addComment($this->generateVarComment($property_name, $property_value));
        });

        return $this;
    }

    private function getParameterType(string $parameter_name): string
    {
        if (! isset($this->provider->properties()[$parameter_name]['type'])) {
            return '';
        }
        if (str_contains((string) $this->provider->properties()[$parameter_name]['type'], 'bool')) {
            return 'bool';
        }

        return $this->provider->properties()[$parameter_name]['type'];
    }

    private function generatePropertieDescription(string $property): string
    {
        return $this->provider->properties()[$property]['description'] ?? '';
    }

    private function generateVarComment(string $property): string
    {
        $local_type = $this->provider->properties()[$property]['type'] ?? '';

        if ($this->isEnum($property)) {
            $enum = '<'.implode('|', $this->provider->properties()[$property]['enum']).'>';
            $local_type = $local_type.$enum;
        }

        return sprintf('@var %s $%s', $local_type, $property);
    }

    private function isNullable(string $parameter_name): bool
    {
        if (isset($this->provider->properties()[$parameter_name]['nullable'])) {
            return $this->provider->properties()[$parameter_name]['nullable'];
        }

        return ! in_array($parameter_name, $this->provider->schema()['required']);
    }

    private function isEnum(string $property): bool
    {
        return isset($this->provider->properties()[$property]['enum']);
    }
}
