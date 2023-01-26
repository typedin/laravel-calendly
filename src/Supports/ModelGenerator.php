<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
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

        $model = new ClassType(Str::singular($model_generator->provider->returnType()));
        $model->setExtends('Typedin\LaravelCalendly\Model');
        $model->validate();

        return $model;
    }
}
