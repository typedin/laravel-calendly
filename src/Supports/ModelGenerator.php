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
        collect($this->provider->schema()['properties'])->each(function ($property, $property_name) {
            $this->model
                    ->getMethod('__construct')
                    ->addParameter($property_name)
                    ->setNullable($this->isNullable($property_name, $property))
                    ->setType($this->getParameterType($property_name, $property));

            $this->model->getMethod('__construct')->addBody(sprintf('$this->%s = $%s;', $property_name, $property_name));
        });

        return $this;
    }

    private function generateProperties(): ModelGenerator
    {
        collect($this->provider->schema()['properties'])->each(function ($property, $property_name) {
            $this->model
                    ->addProperty($property_name)
                    ->setType($this->getParameterType($property_name, $property))
                    ->addComment($this->generatePropertieDescription($property_name, $property))
                    ->addComment($this->generateVarComment($property_name, $property));
        });

        return $this;
    }

    private function isNullable(string $parameter_name): bool
    {
        return ! in_array($parameter_name, $this->provider->schema()['required']);
    }

    private function paramaterIsRef(string $parameter_name): bool
    {
        return isset($this->provider->schema()['properties'][$parameter_name]['$ref']);
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

        return $this->provider->schema()['properties'][$parameter_name]['type'] ?? '';
    }

    private function generatePropertieDescription(string $property, array $applesauce): string
    {
        if ($this->paramaterIsRef($property)) {
            if ($this->provider->schema()['properties'][$property]['$ref'] == 'models/Location.yaml') {
                return '';
            }

            $lookup = explode('/', $applesauce['$ref']);

            return $this->provider->schemas()[Str::ucfirst(end($lookup))]['description'];
        }

        return $this->provider->schema()['properties'][$property]['description'] ?? '';
    }

    private function generateVarComment(string $property): string
    {
        if (isset($this->provider->schema()['properties'][$property]['enum'])) {
            $enum = '<'.implode('|', $this->provider->schema()['properties'][$property]['enum']).'>';

            return sprintf('@var %s $%s', $this->provider->schema()['properties'][$property]['type'].$enum, $property);
        }
        if ($this->isNullable($property)) {
            if (! isset($this->provider->schema()['properties'][$property]['type'])) {
                return sprintf('@var Typedin\LaravelCalendly\Models\%s $%s', Str::ucfirst($property), $property);
            }

            return sprintf('@var %s $%s', $this->provider->schema()['properties'][$property]['type'].'|null', $property);
        }
        if (isset($this->provider->schema()['properties'][$property]['type'])) {
            return sprintf('@var %s $%s', $this->provider->schema()['properties'][$property]['type'], $property);
        }

        return '';
    }
}
