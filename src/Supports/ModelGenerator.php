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
        $this->model = new ClassType(
            name: Str::singular($this->provider->returnType()),
            namespace: new PhpNamespace('Typedin\LaravelCalendly\Models')
        );
    }

    public static function model(ModelGeneratorProvider $provider): ClassType
    {
        $model_generator = new ModelGenerator($provider);

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
                    ->setNullable(TypeHandler::isNullable(property_name: $property_name, property: $property_value, required_lookup:$this->provider->schema()))
                    ->setType(TypeHandler::getType($this->provider->properties()[$property_name]));

            $this->model->getMethod('__construct')->addBody(sprintf('$this->%s = $%s;', $property_name, $property_name));
        });

        return $this;
    }

    private function generateProperties(): ModelGenerator
    {
        collect($this->provider->properties())->each(function ($property_value, $property_name) {
            $type = TypeHandler::getType($this->provider->properties()[$property_name]);
            $this->model
                    ->addProperty($property_name)
                    ->setType($type)
                    ->setNullable(TypeHandler::isNullable(property_name: $property_name, property: $property_value, required_lookup:$this->provider->schema()))
                    ->addComment($this->generatePropertieDescription($property_name))
                    ->addComment($this->generateVarComment($property_name, $type));
        });

        return $this;
    }

    private function generatePropertieDescription(string $property): string
    {
        return $this->provider->properties()[$property]['description'] ?? '';
    }

    private function generateVarComment(string $property, string $type): string
    {
        // don't generate doc for unknown types
        if (! $type) {
            return '';
        }

        if (TypeHandler::isEnum($property)) {
            $enum = '<'.implode('|', $this->provider->properties()[$property]['enum']).'>';
            $type = $type.$enum;
        }

        return sprintf('@var %s $%s', $type, $property);
    }
}
