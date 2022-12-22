<?php

namespace Typedin\LaravelCalendly\Supports;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Nette\PhpGenerator\Method;

class MethodGenerator
{
    public static function handle($class, $modelName, string $method_name, Collection $parameters): Method
    {
        if (! isset($data['parameters'])) {
            dd($modelName, $method_name);
        }
        $method = $class->addMethod($method_name)
                            ->setStatic()
                            ->setReturnType(sprintf("\Typedin\LaravelCalendly\Entities\%s\Calendly%s", $modelName, $modelName));

        $parameters
            ->filter(fn ($param) => isset($param['name']))
            ->each(function ($value) use ($method) {
                $type = $value['schema']['type'] == 'integer' ? 'int' : $value['schema']['type'];
                $name = $value['name'];
                if (isset($value['required'])) {
                    $method->addParameter($name)->setType($type);
                } elseif (isset($value['schema']['default'])) {
                    $method->addParameter($name, $value['schema']['default'])->setType($type);
                } else {
                    $method->addParameter($name, null)->setType($type);
                }
            });

        $method->addBody(sprintf('$response = BaseApiClient::%s("");', $method_name))
        ->addBody('return new '.self::buildModelName($modelName).'($response->json("resource"), "users"); ');

        return $method;
    }

    private static function buildModelName($modelName): string
    {
        $all = collect(explode(' ', $modelName))
                    ->map(fn ($value) => ucfirst($value));

        return 'Calendly'.Str::singular(implode($all->all()));
    }
}
