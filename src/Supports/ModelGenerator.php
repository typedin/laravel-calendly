<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Typedin\LaravelCalendly\Supports\Configuration\ModelGeneratorProvider;

class ModelGenerator
{
    public readonly ClassType $model;

    public function __construct(private readonly ModelGeneratorProvider $provider)
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
        collect($this->provider->schema()['properties'])->each(function ($property_value, $property_name) {
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
        collect($this->provider->schema()['properties'])->each(function ($property_value, $property_name) {
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
        if ($this->paramaterIsRef($parameter_name)) {
            if ($this->provider->schema()['properties'][$parameter_name]['$ref'] == 'models/Location.yaml') {
                return '';
            }

            $lookup = explode('/', $this->provider->schema()['properties'][$parameter_name]['$ref']);

            return end($lookup);
        }
        if (str_contains((string) $this->provider->schema()['properties'][$parameter_name]['type'], 'bool')) {
            return 'bool';
        }

        return $this->provider->schema()['properties'][$parameter_name]['type'];
    }

    private function generatePropertieDescription(string $property): string
    {
        if ($this->paramaterIsRef($property)) {
            if ($this->provider->getRef($property) == 'models/Location.yaml') {
                return '';
            }
            $lookup = explode('/', $this->provider->getRef($property));

            return $this->provider->schemas()[Str::ucfirst(end($lookup))]['description'];
        }

        return $this->provider->schema()['properties'][$property]['description'] ?? '';
    }

    private function generateVarComment(string $property): string
    {
        $local_type = $this->provider->schema()['properties'][$property]['type'] ?? '';

        if ($this->isEnum($property)) {
            $enum = '<'.implode('|', $this->provider->schema()['properties'][$property]['enum']).'>';
            $local_type = $local_type.$enum;
        }
        if ($this->isReference($property)) {
            $local_type = 'Typedin\LaravelCalendly\Models\\'.Str::ucfirst($property);
        }

        return sprintf('@var %s $%s', $local_type, $property);
    }

    private function isNullable(string $parameter_name): bool
    {
        if (isset($this->provider->schema()['properties'][$parameter_name]['nullable'])) {
            if ($parameter_name == 'avatar_url') {
                return $this->provider->schema()['properties'][$parameter_name]['nullable'];

                return  true;
            }

            return $this->provider->schema()['properties'][$parameter_name]['nullable'];
        }

        return ! in_array($parameter_name, $this->provider->schema()['required']);
    }

    private function paramaterIsRef(string $parameter_name): bool
    {
        return (bool) $this->provider->getRef($parameter_name);
    }

    private function isReference(string $property): bool
    {
        return $this->isNullable($property) && ! isset($this->provider->schema()['properties'][$property]['type']);
    }

    private function isEnum(string $property): bool
    {
        return isset($this->provider->schema()['properties'][$property]['enum']);
    }
}
