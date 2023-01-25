<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Typedin\LaravelCalendly\Supports\Configuration\FormRequestProvider;

class ModelGenerator
{
    public readonly ClassType $model;

    /**
     * @param  array<int,mixed>  $path
     * @param  array<int,mixed>  $parameters
     */
    public function __construct(private readonly FormRequestProvider $dto)
    {
    }

    public static function model(FormRequestProvider $dto): ClassType
    {
        $model_generator = new ModelGenerator($dto);

        $model = new ClassType(Str::singular($model_generator->dto->name));
        $model->setExtends('Typedin\LaravelCalendly\Model');
        $model->validate();

        return $model;
    }
}
